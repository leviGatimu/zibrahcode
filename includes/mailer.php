<?php
/**
 * Thin PHPMailer wrapper for transactional + subscriber-broadcast email.
 * Requires SMTP_* constants in config.php. If SMTP_HOST is blank, sending
 * is silently skipped (so the site keeps working before credentials are set).
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

function mailerIsConfigured(): bool
{
    return SMTP_HOST !== '' && SMTP_USERNAME !== '' && SMTP_FROM_EMAIL !== '';
}

function makeMailer(): PHPMailer
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->Port = SMTP_PORT;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_SECURE === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    return $mail;
}

/**
 * Renders a fully self-contained, inline-styled HTML email (table-based
 * layout, no external CSS/fonts) so it renders consistently across Gmail,
 * Outlook, Apple Mail, etc. Used for the "new post/episode" broadcast, but
 * generic enough to reuse for any future subscriber notification.
 */
function renderNotificationEmail(string $eyebrow, string $heading, string $bodyText, ?string $imageUrl, string $ctaText, string $ctaUrl): string
{
    $year = date('Y');
    $eyebrow = e($eyebrow);
    $heading = e($heading);
    $bodyText = nl2br(e($bodyText));
    $ctaText = e($ctaText);
    $ctaUrl = e($ctaUrl);
    $imageRow = '';
    if ($imageUrl) {
        $imageRow = '<tr><td style="padding:0;"><img src="' . e($imageUrl) . '" width="560" alt="" style="width:100%;max-width:560px;height:auto;display:block;border:0;"></td></tr>';
    }

    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{$eyebrow}</title>
</head>
<body style="margin:0; padding:0; background-color:#F2F2F2; font-family:Arial, Helvetica, sans-serif;">
<span style="display:none; max-height:0; overflow:hidden; opacity:0;">{$heading}</span>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F2F2F2; padding:40px 16px;">
<tr><td align="center">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background-color:#FFFFFF;">
<tr><td style="background-color:#1A1A1A; padding:32px 40px; text-align:center;">
<span style="font-family:Georgia,'Times New Roman',serif; font-size:22px; font-weight:bold; letter-spacing:4px; color:#FFFFFF; text-transform:uppercase;">ZIBRAH CODE<span style="color:#B89441;">&trade;</span></span>
</td></tr>
{$imageRow}
<tr><td style="padding:40px;">
<p style="margin:0 0 14px; font-size:11px; font-weight:bold; letter-spacing:3px; text-transform:uppercase; color:#B89441;">{$eyebrow}</p>
<h1 style="margin:0 0 20px; font-family:Georgia,'Times New Roman',serif; font-size:26px; line-height:1.35; color:#1A1A1A;">{$heading}</h1>
<p style="margin:0 0 28px; font-size:16px; line-height:1.6; color:#525252;">{$bodyText}</p>
<table role="presentation" cellpadding="0" cellspacing="0">
<tr><td style="background-color:#B89441;">
<a href="{$ctaUrl}" style="display:inline-block; padding:14px 32px; font-size:12px; font-weight:bold; letter-spacing:2px; text-transform:uppercase; color:#1A1A1A; text-decoration:none;">{$ctaText}</a>
</td></tr>
</table>
</td></tr>
<tr><td style="padding:24px 40px; background-color:#FAFAFA; border-top:1px solid #E5E5E5; text-align:center;">
<p style="margin:0 0 6px; font-size:11px; color:#A3A3A3;">You're receiving this because you subscribed to Zibrah Code updates. <a href="{{UNSUBSCRIBE_URL}}" style="color:#A3A3A3; text-decoration:underline;">Unsubscribe</a></p>
<p style="margin:0; font-size:11px; color:#A3A3A3;">&copy; {$year} Zibrah Research Collective</p>
</td></tr>
</table>
</td></tr>
</table>
</body>
</html>
HTML;
}

/**
 * Send a single transactional email. Returns true on success, false if
 * unconfigured or on failure (failure is logged, never thrown to the caller).
 */
function sendEmail(string $toEmail, string $toName, string $subject, string $htmlBody, string $altBody = ''): bool
{
    if (!mailerIsConfigured()) {
        return false;
    }
    try {
        $mail = makeMailer();
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->AltBody = $altBody !== '' ? $altBody : strip_tags($htmlBody);
        $mail->send();
        return true;
    } catch (PHPMailerException $e) {
        error_log('Mailer error sending to ' . $toEmail . ': ' . $e->getMessage());
        return false;
    }
}

/**
 * Broadcast an email to every subscribed newsletter subscriber, reusing one
 * SMTP connection. A failure on one recipient does not stop the others.
 * Returns the number of emails successfully sent.
 */
function notifySubscribers(string $subject, string $htmlBody, string $altBody = ''): int
{
    if (!mailerIsConfigured()) {
        return 0;
    }

    $subscribers = getDb()->query(
        'SELECT email, name FROM newsletter_subscribers WHERE status = "subscribed"'
    )->fetchAll();

    if (empty($subscribers)) {
        return 0;
    }

    $sent = 0;
    try {
        $mail = makeMailer();
        $mail->SMTPKeepAlive = true;
        $mail->Subject = $subject;

        foreach ($subscribers as $subscriber) {
            try {
                $unsubUrl = unsubscribeUrl($subscriber['email']);
                $mail->clearAddresses();
                $mail->clearCustomHeaders();
                $mail->addAddress($subscriber['email'], $subscriber['name'] ?: '');
                $mail->Body = str_replace('{{UNSUBSCRIBE_URL}}', $unsubUrl, $htmlBody);
                $mail->AltBody = ($altBody !== '' ? $altBody : strip_tags($htmlBody)) . "\n\nUnsubscribe: $unsubUrl";
                // RFC 8058 one-click unsubscribe — lets Gmail/Yahoo/Outlook show a
                // native "Unsubscribe" affordance next to the sender, which is one
                // of the strongest signals those inboxes use to keep bulk mail out
                // of spam.
                $mail->addCustomHeader('List-Unsubscribe', "<$unsubUrl>");
                $mail->addCustomHeader('List-Unsubscribe-Post', 'List-Unsubscribe=One-Click');
                $mail->send();
                $sent++;
            } catch (PHPMailerException $e) {
                error_log('Mailer error notifying ' . $subscriber['email'] . ': ' . $e->getMessage());
            }
        }

        $mail->smtpClose();
    } catch (PHPMailerException $e) {
        error_log('Mailer error establishing SMTP connection: ' . $e->getMessage());
    }

    return $sent;
}
