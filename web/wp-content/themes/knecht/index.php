<?php
$host = $_SERVER['HTTP_HOST'] ?? 'unknown';

$env = [
    'Host' => $host,
    'PHP version' => PHP_VERSION,
    'WordPress version' => get_bloginfo('version'),
    'Server software' => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
    'Scheme' => is_ssl() ? 'https' : 'http',
    'Request URI' => $_SERVER['REQUEST_URI'] ?? '/',
    'Client IP' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'Timezone' => wp_timezone_string(),
    'Server time' => wp_date('Y-m-d H:i:s'),
];
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <main class="kit-container kit-stack">

    <span class="kit-badge kit-mb-4">wordpress-test-e2e</span>

    <h1>WordPress Fixture <span class="kit-accent-text">Knecht.works</span></h1>

    <p class="kit-muted">
      A small demo page, built with the Knecht Styleguide Kit. Served from
      <code class="kit-code"><?= esc_html($host) ?></code> at <?= esc_html(wp_date('H:i:s')) ?>.
    </p>

    <div class="kit-stack">
      <a class="kit-button kit-button--solid" href="https://knecht.works">Go to knecht.works</a>
      <button class="kit-button" data-kit-toast="Up and running! 🚀">Show toast</button>
      <a class="kit-button kit-button--ghost" href="https://github.com/knecht-works/test-wordpress">Go to Repo</a>
    </div>

    <section class="kit-card kit-stack kit-mt-8">
      <dl class="kit-dl">
        <?php foreach ($env as $label => $value): ?>
        <div class="kit-dl-row">
          <dt><?= esc_html($label) ?></dt>
          <dd><?= esc_html((string) $value) ?></dd>
        </div>
        <?php endforeach; ?>
        <div class="kit-dl-row">
          <dt>Vite bundle</dt>
          <dd data-vite-status="pending">not loaded</dd>
        </div>
      </dl>
    </section>

    <p class="kit-muted">
      <a href="<?= esc_url(wp_login_url()) ?>">admin login</a>
    </p>

  </main>
  <?php wp_footer(); ?>
</body>
</html>
