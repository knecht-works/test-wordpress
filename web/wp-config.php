<?php

// WordPress core lives in web/wp (installed by composer), the content
// directory stays next to it in web/wp-content. The site URL follows the host
// DDEV (or Knecht) serves the project on, so the seed dump boots on any host.
define('WP_HOME', rtrim(getenv('DDEV_PRIMARY_URL') ?: 'https://test-wordpress.ddev.site', '/'));
define('WP_SITEURL', WP_HOME . '/wp');
define('WP_CONTENT_DIR', __DIR__ . '/wp-content');
define('WP_CONTENT_URL', WP_HOME . '/wp-content');

// Database credentials come from the file DDEV generates on start.
$ddev_settings = __DIR__ . '/wp-config-ddev.php';
if (is_readable($ddev_settings)) {
    require_once $ddev_settings;
}

// Fixed on purpose: this is a public test fixture with a public admin login.
define('AUTH_KEY', 'knecht-e2e-auth-key');
define('SECURE_AUTH_KEY', 'knecht-e2e-secure-auth-key');
define('LOGGED_IN_KEY', 'knecht-e2e-logged-in-key');
define('NONCE_KEY', 'knecht-e2e-nonce-key');
define('AUTH_SALT', 'knecht-e2e-auth-salt');
define('SECURE_AUTH_SALT', 'knecht-e2e-secure-auth-salt');
define('LOGGED_IN_SALT', 'knecht-e2e-logged-in-salt');
define('NONCE_SALT', 'knecht-e2e-nonce-salt');

$table_prefix = 'wp_';

define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISALLOW_FILE_MODS', true);

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/wp/');
}

require_once ABSPATH . 'wp-settings.php';
