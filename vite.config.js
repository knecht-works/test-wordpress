import { defineConfig } from 'vite'

// Assets are built into web/dist and read back through the manifest by the
// knecht theme (web/wp-content/themes/knecht/functions.php). No WordPress
// Vite plugin: the theme includes the bundle by hand.
export default defineConfig(({ command }) => ({
  // The docroot is not a Vite public dir: it must not be copied into the build.
  publicDir: false,
  // The dev server serves from the root: the theme builds the dev URLs as
  // <dev server>/<source path>.
  base: command === 'serve' ? '/' : '/dist/',
  build: {
    manifest: true,
    outDir: 'web/dist',
    emptyOutDir: true,
    rollupOptions: {
      input: ['src/js/app.js', 'src/css/app.css'],
    },
  },
  server: {
    // DDEV: Vite runs inside the web container and is exposed via
    // web_extra_exposed_ports (https://<project>.ddev.site:5173).
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    allowedHosts: true,
    cors: {
      origin: /https?:\/\/([A-Za-z0-9\-\.]+)?(localhost|\.local|\.test|\.site)(?::\d+)?$/,
    },
  },
}))
