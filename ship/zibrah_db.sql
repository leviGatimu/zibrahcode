-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: zibrah_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'ibrahim','admin@zibrahcode.test','$2y$10$aR.jfBJwi5ivxy5ce5ggxeVcHibiHrABKxLz8SMYpGD40tPMdyHVu','Ibrahim Ngugi',NULL,'2026-07-06 01:31:20','2026-07-07 00:42:17');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointment_requests`
--

DROP TABLE IF EXISTS `appointment_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointment_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `preferred_date` date DEFAULT NULL,
  `preferred_time` varchar(50) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','contacted','scheduled','closed') DEFAULT 'new',
  `created_at` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment_requests`
--

LOCK TABLES `appointment_requests` WRITE;
/*!40000 ALTER TABLE `appointment_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointment_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookmarks`
--

DROP TABLE IF EXISTS `bookmarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookmarks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `bookmarkable_type` enum('post','episode') NOT NULL,
  `bookmarkable_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_bookmark` (`user_id`,`bookmarkable_type`,`bookmarkable_id`),
  CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookmarks`
--

LOCK TABLES `bookmarks` WRITE;
/*!40000 ALTER TABLE `bookmarks` DISABLE KEYS */;
INSERT INTO `bookmarks` VALUES (3,2,'post',2,'2026-07-06 01:25:52');
/*!40000 ALTER TABLE `bookmarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commentable_type` enum('post','episode') NOT NULL,
  `commentable_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `body` text NOT NULL,
  `status` enum('visible','deleted') DEFAULT 'visible',
  `created_at` datetime DEFAULT current_timestamp(),
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `is_liked_by_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_commentable` (`commentable_type`,`commentable_id`,`status`),
  KEY `idx_user` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'post',1,2,'This is nice!','deleted','2026-07-06 01:25:27',0,0),(2,'post',2,2,'This reframing of belief as geometry rather than argument is a genuinely useful lens. Thank you for writing this.','visible','2026-07-06 01:25:45',0,0);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','archived') DEFAULT 'new',
  `created_at` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `guest_token` varchar(64) DEFAULT NULL,
  `likeable_type` enum('post','episode','comment') NOT NULL,
  `likeable_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_like` (`user_id`,`likeable_type`,`likeable_id`),
  UNIQUE KEY `uniq_like_guest` (`guest_token`,`likeable_type`,`likeable_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (6,2,NULL,'comment',2,'2026-07-06 23:44:41');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(190) NOT NULL,
  `attempted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `identifier` (`identifier`,`attempted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter_subscribers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `status` enum('subscribed','unsubscribed') DEFAULT 'subscribed',
  `source` varchar(50) DEFAULT NULL,
  `subscribed_at` datetime DEFAULT current_timestamp(),
  `unsubscribed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `newsletter_subscribers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
INSERT INTO `newsletter_subscribers` VALUES (1,'testreader@example.com','Test Reader',1,'subscribed','registration','2026-07-06 01:24:32',NULL),(2,'getmorelev@gmail.com','Levi Gatimu',2,'subscribed','registration','2026-07-06 01:24:37',NULL);
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_episodes`
--

DROP TABLE IF EXISTS `podcast_episodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_episodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `meta_description` varchar(300) DEFAULT NULL,
  `show_notes` longtext DEFAULT NULL,
  `audio_file_path` varchar(255) DEFAULT NULL,
  `media_type` enum('audio','video') NOT NULL DEFAULT 'audio',
  `video_file_path` varchar(255) DEFAULT NULL,
  `audio_duration_seconds` int(10) unsigned DEFAULT NULL,
  `cover_image_path` varchar(255) DEFAULT NULL,
  `episode_number` int(10) unsigned DEFAULT NULL,
  `season_number` int(10) unsigned DEFAULT 1,
  `status` enum('draft','published') DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_status_published` (`status`,`published_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_episodes`
--

LOCK TABLES `podcast_episodes` WRITE;
/*!40000 ALTER TABLE `podcast_episodes` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcast_episodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `body` longtext NOT NULL,
  `featured_image_path` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `podcast_episode_id` int(10) unsigned DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `author_name` varchar(100) DEFAULT 'Ibrahim Ngugi',
  `meta_description` varchar(300) DEFAULT NULL,
  `legacy_slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_status_published` (`status`,`published_at`),
  KEY `podcast_episode_id` (`podcast_episode_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`podcast_episode_id`) REFERENCES `podcast_episodes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Zibrah Code Foundational Structure','zibrah-code-foundational-structure','A visual representation of the independent dimensions of truth and perception.','<p>Every framework needs a shape. Zibrah Code\'s shape is deliberately simple: two independent lines &mdash; truth and perception &mdash; set at an angle to each other, not stacked, not merged.</p>\n<p>Most models collapse truth and perception into a single axis, as if believing something harder makes it truer. Zibrah Code refuses that collapse. Truth stands on its own line. Perception stands on its own line. What happens between them &mdash; the angle &mdash; is where belief actually lives.</p>\n<p>This separation is the entire foundation. Once truth and perception are treated as independent, their relationship becomes something that can be measured, not just argued about. A narrow angle signals rigid belief. A wide angle signals openness. Neither position is inherently right &mdash; but each is visible, and visibility is the beginning of correction.</p>\n<p>The diagram that accompanies this structure is not decoration. It is the argument. Two dimensions, held apart, describe more about human disagreement than a thousand words of explanation could.</p>\n<p>Every axiom that follows in the Zibrah Code framework &mdash; how belief forms, how extremes mirror each other, how wisdom differs from projection &mdash; descends directly from this one structural decision: keep truth and perception separate, and watch what moves between them.</p>\n<p>Structure is not the whole of wisdom. But without it, wisdom has nowhere to stand.</p>\n<p class=\"font-bold text-brand-gold italic\">Angles show what words cannot tell.</p>','assets/images/blog.png','Framework & Theory',NULL,'published','2026-05-13 09:00:00','2026-07-06 01:06:42',NULL,'Ibrahim Ngugi','Explore the foundational geometric structure of the Zibrah Code model — a visual representation of how truth and perception interact to form belief, conflict, and wisdom.','post-structure.php'),(2,'Angles Show What Words Cannot Tell','angles-show-what-words-cannot-tell','Most conflicts do not begin with malice. They begin with certainty.','<p>Most conflicts do not begin with malice. They begin with certainty.</p>\n<p>Certainty feels like clarity, but the two are not the same. Clarity remains responsive. Certainty accelerates.</p>\n<p>When belief accelerates faster than understanding, something subtle but decisive happens: listening weakens, correction fails, and disagreement begins to feel like threat.</p>\n<p>This is not a failure of intelligence. It is not a moral defect. It is structural.</p>\n<p>Belief moves. It moves through affirmation and doubt, through confidence and restraint, through openness and closure. These movements follow patterns that are surprisingly consistent across individuals, groups, institutions, and societies.</p>\n<p>Arguments try to interrupt these patterns. They rarely succeed. Geometry, however, reveals them.</p>\n<p>When belief remains open, its angles are wide. When belief hardens, angles narrow. When belief closes, angles lock. None of this requires judgment. It can be seen.</p>\n<p>This is why some conversations fail no matter how well they are argued. It is why mediation arrives too late. It is why leadership escalates problems it intends to solve. And it is why radicalization does not feel radical from the inside.</p>\n<p>Belief does not collapse suddenly. It closes gradually.</p>\n<p>There is usually a moment&mdash;quiet and easy to miss&mdash;when reality is still acknowledged but no longer obeyed. From that point onward, correction becomes ineffective, not because facts disappear, but because belief can no longer rotate.</p>\n<p>Understanding this changes nothing immediately. And yet, it changes everything eventually. Because once belief is seen as something that moves, narrows, and locks, blame loses its usefulness. The question shifts from <em>who is wrong</em> to <em>what stage has been reached</em>. That shift alone lowers temperature.</p>\n<p>The most important insight, however, comes later. As people learn to recognize these patterns outwardly&mdash;in conflicts, in leaders, in movements&mdash;they eventually encounter the same geometry inwardly. This recognition is rarely announced. It does not need to be. It is private, personal, and often silent.</p>\n<p>That silence is not avoidance. It is understanding settling.</p>\n<p>The most durable insights do not arrive through force. They arrive when structure becomes visible.</p>\n<p class=\"font-bold text-brand-gold italic\">Angles show what words cannot tell.</p>','assets/images/wisdom.jpg','Strategic Research',NULL,'published','2026-02-20 09:00:00','2026-07-06 01:06:42',NULL,'Ibrahim Ngugi','Most conflicts begin with certainty, not malice. Explore how belief narrows and locks — and why geometry reveals what arguments cannot.','post-angles.php');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schema_migrations`
--

DROP TABLE IF EXISTS `schema_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schema_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration_name` varchar(255) NOT NULL,
  `run_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `migration_name` (`migration_name`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schema_migrations`
--

LOCK TABLES `schema_migrations` WRITE;
/*!40000 ALTER TABLE `schema_migrations` DISABLE KEYS */;
INSERT INTO `schema_migrations` VALUES (1,'001_create_admin_users','2026-07-06 01:06:42'),(2,'002_create_users','2026-07-06 01:06:42'),(3,'003_create_posts','2026-07-06 01:06:42'),(4,'004_create_podcast_episodes','2026-07-06 01:06:42'),(5,'005_create_comments','2026-07-06 01:06:42'),(6,'006_create_bookmarks','2026-07-06 01:06:42'),(7,'007_create_newsletter_subscribers','2026-07-06 01:06:42'),(8,'008_create_contact_messages','2026-07-06 01:06:42'),(9,'009_seed_initial_posts','2026-07-06 01:06:42'),(10,'010_create_appointment_requests','2026-07-06 20:25:34'),(11,'011_create_likes','2026-07-06 22:00:40'),(12,'012_add_media_type_to_podcast_episodes','2026-07-06 22:29:38'),(13,'013_add_podcast_episode_link_to_posts','2026-07-06 22:29:38'),(14,'014_add_pin_like_to_comments','2026-07-06 23:13:55'),(15,'015_add_avatar_to_admin_users','2026-07-06 23:13:55'),(16,'016_allow_anonymous_likes','2026-07-06 23:35:35'),(17,'017_create_settings','2026-07-07 00:55:04'),(18,'018_add_meta_description_to_podcast_episodes','2026-07-07 01:15:43'),(19,'019_create_login_attempts','2026-07-07 08:03:33');
/*!40000 ALTER TABLE `schema_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `newsletter_opt_in` tinyint(1) DEFAULT 1,
  `status` enum('active','suspended') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test Reader','testreader@example.com','$2y$10$rfZybzhhrUgerHnvlr7t8uPkCDrAW3QCyxOAhFwAvzebmbDm3dtFO',NULL,1,'active','2026-07-06 01:24:32',NULL),(2,'Levi Gatimu','getmorelev@gmail.com','$2y$10$ZYeWxCg1cEFi9eIO9v3jtengUznzIKBialhYH0.hxi5giAAMGodNy','uploads/users/avatars/2-1783404194.png',1,'active','2026-07-06 01:24:37','2026-07-07 08:03:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'zibrah_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-07  8:24:54
