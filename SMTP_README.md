PHPMailer + SMTP setup

This project can use PHPMailer to send contact form messages via SMTP (recommended for reliability).

1) Install Composer (if not already installed):
   https://getcomposer.org/download/

2) From the project root, install PHPMailer with Composer:

   composer require phpmailer/phpmailer

   This will create a `vendor/` directory with an autoloader (`vendor/autoload.php`).

3) Configure environment variables (recommended) on your hosting or in your environment:

   SMTP_HOST   - SMTP server hostname (e.g., smtp.sendgrid.net)
   SMTP_PORT   - SMTP port (587 for TLS, 465 for SSL)
   SMTP_USER   - SMTP username (e.g., SMTP/API key)
   SMTP_PASS   - SMTP password or API key
   SMTP_SECURE - 'tls' or 'ssl' (defaults to 'tls')
   SMTP_FROM   - From address (optional, defaults to SMTP_USER)
   SMTP_FROM_NAME - From display name (optional)
   SMTP_TO     - Optional override for recipient (defaults to info@balancepointconsulting.llc)

4) On many hosts you can set env variables in the control panel. For local testing you can create a .env loader or set variables in your shell before running PHP's built-in server.

5) The `send-email.php` will automatically use PHPMailer+SMTP if Composer's autoload is present and SMTP variables are set. If PHPMailer isn't installed or SMTP isn't configured, it falls back to PHP's mail().

Security notes
- Do NOT commit SMTP credentials to source control.
- Prefer storing credentials as environment variables or in a config file outside the webroot.

If you'd like, I can also add an example `sendmail.env.example` file and a small script to load environment variables in development.