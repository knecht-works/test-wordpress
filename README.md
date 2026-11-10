<div align="center">

  <img src="https://knecht.works/styleguide/favicon/favicon.svg" alt="Knecht" width="112" height="112">

# test-wordpress

<p>
  <img src="https://img.shields.io/badge/WordPress-7.x-21759B?logo=wordpress&logoColor=white" alt="WordPress 7.x">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/DDEV-nginx--fpm-02A8E2?logo=docker&logoColor=white" alt="DDEV · nginx-fpm">
  <img src="https://img.shields.io/badge/Knecht-e2e%20fixture-b7f8a2?labelColor=09090b" alt="Knecht e2e fixture">
  <img src="https://img.shields.io/badge/license-MIT-blue" alt="MIT License">
</p>

</div>

A [DDEV](https://ddev.com)-based WordPress project used as an end-to-end test fixture for [Knecht](https://knecht.works). WordPress core is installed by Composer ([roots/wordpress](https://github.com/roots/wordpress)) into `web/wp`, next to a tiny custom theme (`web/wp-content/themes/knecht`) that renders a demo front page built with the Knecht Styleguide Kit, so Knecht can boot the environment, hit the site, and assert against real CMS behavior (rendered theme templates, database queries, the admin login). The database ships as a seed dump in `seed/db.sql.gz`, so no interactive installer is needed. Front-end assets (`src/`) are bundled with [Vite](https://vitejs.dev) into `web/dist` and included by the theme through the manifest, without a plugin: the "Vite bundle" row on the front page flips from "not loaded" to "loaded" once the built script runs.

## Setup

Requires [DDEV](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/) and a Docker provider (Docker, OrbStack, or Colima).

```bash
ddev start                                # boot the containers
ddev composer install                     # install WordPress core into web/wp
ddev import-db --file=seed/db.sql.gz      # load the pre-installed site
ddev npm install
ddev npm run build                        # build src/ into web/dist, or `ddev npm run dev` for the Vite dev server
```

The seed already contains the installed site (site name `test-wordpress`, active theme `knecht`) with one administrator account:

| Username | Password   |
| -------- | ---------- |
| `admin`  | `admin123` |

To recreate the seed after changing the site, run `ddev export-db --file=seed/db.sql.gz`. The dump does not reference any uploaded files, so nothing under `web/wp-content/uploads` needs to be tracked. The site URL is not taken from the dump: `web/wp-config.php` sets `WP_HOME` from `DDEV_PRIMARY_URL`, so the same seed boots on any host.

## URLs

`ddev launch` opens the site in your browser.

| Role        | URL                                                |
| ----------- | -------------------------------------------------- |
| Site        | `https://test-wordpress.ddev.site`                 |
| Admin login | `https://test-wordpress.ddev.site/wp/wp-login.php` |
| Dashboard   | `https://test-wordpress.ddev.site/wp/wp-admin/`    |
