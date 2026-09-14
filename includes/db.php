<?php
/**
 * Database connection + zero-touch schema auto-provisioning.
 * Creates the database and every table automatically on first run —
 * no manual phpMyAdmin/SQL steps are ever required.
 */

function getDb(): PDO
{
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // Try connecting straight to the target database first. This is the only
    // path available on most shared hosts, where the DB is pre-created via the
    // host's control panel and the DB user has no server-wide CREATE privilege.
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        // Database doesn't exist yet (typical on a fresh local/VPS install where
        // the DB user *does* have CREATE privileges) — create it, then connect.
        $server = new PDO('mysql:host=' . DB_HOST . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        try {
            $server->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        } catch (PDOException $createException) {
            throw new RuntimeException(
                'Could not connect to database "' . DB_NAME . '" and could not create it either ' .
                '(insufficient privileges). On shared hosting, create the database "' . DB_NAME . '" ' .
                'manually via your host\'s control panel (e.g. cPanel > MySQL Databases), then reload.',
                0,
                $createException
            );
        }
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, $options);
    }

    runMigrations($pdo);

    return $pdo;
}

function runMigrations(PDO $pdo): void
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS schema_migrations (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            migration_name VARCHAR(255) UNIQUE NOT NULL,
            run_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB'
    );

    $migrationsDir = __DIR__ . '/migrations';
    $files = glob($migrationsDir . '/*.php');
    sort($files);

    // Compare by name, never by count. An environment can legitimately hold an
    // applied migration whose file is no longer present (a rolled-back feature,
    // a database shared with a newer checkout), and a count comparison reads
    // that as "nothing to do" — silently freezing every future migration with
    // no error anywhere. Names are the only reliable signal. This is also a
    // single query, so it costs no more than the count check it replaces.
    $applied = $pdo->query('SELECT migration_name FROM schema_migrations')->fetchAll(PDO::FETCH_COLUMN);
    $appliedSet = array_flip($applied);

    foreach ($files as $file) {
        $name = basename($file, '.php');
        if (isset($appliedSet[$name])) {
            continue;
        }
        $migration = require $file;
        if (is_callable($migration)) {
            $migration($pdo);
        }
        $stmt = $pdo->prepare('INSERT INTO schema_migrations (migration_name) VALUES (?)');
        $stmt->execute([$name]);
    }
}
