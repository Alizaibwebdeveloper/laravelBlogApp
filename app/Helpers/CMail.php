<?php
    
namespace App\Helpers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Log;

class CMail {
    public static function send($config) {
        // Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Send using SMTP
            $mail->Host = config('services.mail.host');
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = config('services.mail.username'); // SMTP username
            $mail->Password = config('services.mail.password'); // SMTP password
            $mail->SMTPSecure = config('services.mail.encryption'); // Enable implicit TLS encryption
            $mail->Port = config('services.mail.port'); // TCP port to connect to; use 587 for `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Recipients
            $mail->setFrom(
                isset($config['from_address']) ? $config['from_address'] : config('services.mail.from_address'),
                isset($config['from_name']) ? $config['from_name'] : config('services.mail.from_name')
            );
            $mail->addAddress($config['recipient_address'], isset($config['recipient_name']) ? $config['recipient_name'] : null);

            // Attachments (if any)
            if (isset($config['attachments']) && is_array($config['attachments'])) {
                foreach ($config['attachments'] as $attachment) {
                    $mail->addAttachment($attachment['path'], $attachment['name']);
                }
            }

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $config['subject'];
            $mail->Body = $config['body'];
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if (!$mail->send()) {
                \Log::error('Mail send failed: ' . $mail->ErrorInfo);
                return false;
            }
            return true;
        } catch (Exception $e) {
            \Log::error('PHPMailer error: ' . $e->getMessage());
            return false;
        }
    }
}




?>