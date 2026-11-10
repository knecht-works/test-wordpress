<?php

add_action('after_setup_theme', function (): void {
    add_theme_support('title-tag');
});

add_filter('pre_get_document_title', fn (): string => 'WordPress Test | Knecht');

add_action('wp_enqueue_scripts', function (): void {
    wp_enqueue_style('knecht-kit', 'https://knecht.works/styleguide/kit.css', [], null);
    wp_enqueue_script('knecht-kit', 'https://knecht.works/styleguide/kit.js', [], null, ['strategy' => 'defer']);
});

add_action('wp_head', function (): void {
    echo knecht_vite('src/css/app.css') . "\n";
    echo knecht_vite('src/js/app.js') . "\n";
    echo '<link rel="icon" type="image/svg+xml" href="/favicon.svg" />' . "\n";
});

add_filter('body_class', fn (array $classes): array => [...$classes, 'kit-body', 'kit-light']);

// Tags for a Vite entry. With a dev server (Knecht hands its browser-facing
// URL in as KNECHT_DEV_SERVER_URL) the entry is loaded from there, with the
// HMR client once in front. Otherwise the tags come from the manifest that
// `npm run build` writes; a missing manifest renders a comment instead of
// failing the page.
function knecht_vite(string $entry): string
{
    static $manifest = null;
    static $clientEmitted = false;
    $dev = getenv('KNECHT_DEV_SERVER_URL');
    if ($dev) {
        $dev = rtrim($dev, '/');
        $tags = '';
        if (!$clientEmitted) {
            $clientEmitted = true;
            $tags .= '<script type="module" src="' . esc_url($dev . '/@vite/client') . '"></script>' . "\n";
        }
        $src = esc_url($dev . '/' . ltrim($entry, '/'));
        return $tags . (str_ends_with($entry, '.css')
            ? '<link rel="stylesheet" href="' . $src . '">'
            : '<script type="module" src="' . $src . '"></script>');
    }
    if ($manifest === null) {
        $file = dirname(WP_CONTENT_DIR) . '/dist/.vite/manifest.json';
        $manifest = is_file($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];
    }
    $chunk = $manifest[$entry] ?? null;
    if (!$chunk) {
        return '<!-- vite: no manifest entry for ' . esc_html($entry) . ', run `npm run build` -->';
    }
    $tags = '';
    foreach ($chunk['css'] ?? [] as $css) {
        $tags .= '<link rel="stylesheet" href="' . esc_url('/dist/' . $css) . '">' . "\n";
    }
    $tags .= str_ends_with($chunk['file'], '.css')
        ? '<link rel="stylesheet" href="' . esc_url('/dist/' . $chunk['file']) . '">'
        : '<script type="module" src="' . esc_url('/dist/' . $chunk['file']) . '"></script>';
    return $tags;
}
