# OpenDXP | Project Skeleton 

This skeleton should be used by experienced OpenDXP developers for starting a new project from the ground up. 

## Disclaimer

> OpenDXP is a community-driven fork based on the Pimcore® Community Edition (GPLv3).  
> OpenDXP is independent and maintained by its community and contributors.
> It is not affiliated with, endorsed by, or sponsored by Pimcore GmbH.   
> Original credits: [Pimcore GmbH](https://www.pimcore.com)

**OpenDXP Skeleton is based on the Pimcore® Community Edition and remains licensed under GPLv3.**

***

## Getting started
```bash
COMPOSER_MEMORY_LIMIT=-1 composer create-project open-dxp/skeleton my-project
cd ./my-project
./vendor/bin/opendxp-install
```

- Point your virtual host to `my-project/public`
- [Only for Apache] Create `my-project/public/.htaccess` according to docs/Installation_and_Upgrade/System_Setup_and_Hosting/Apache_Configuration/ 
- Open https://your-host/admin in your browser
- Done!

## Note for first-time setup
To allow cache:clear and other commands to run without an active database connection, the default configuration sets:

```yaml
doctrine:
    dbal:
        connections:
            default:
                server_version: '%env(string:default:default_database_server_version:DATABASE_SERVER_VERSION)%'
```

The default comes from the `default_database_server_version` parameter in `config/services.yaml`.
If you're using a different database version, change that parameter or override it in your `.env` or `.env.local`:

```dotenv
DATABASE_SERVER_VERSION=mariadb-10.11.13
```

## Docker

You can also use Docker to set up a new OpenDXP Installation.
You don't need to have a PHP environment with composer installed.

### Prerequisites
* Your user must be allowed to run docker commands (directly or via sudo).
* You must have docker compose installed.
* Your user must be allowed to change file permissions (directly or via sudo).

### Follow these steps
1. Initialize the skeleton project using the `opendxp/opendxp` image
``docker run -u `id -u`:`id -g` --rm -v `pwd`:/var/www/html opendxp/opendxp:php8.3-latest composer create-project open-dxp/skeleton my-project``

2. Go to your new project
`cd my-project/`

3. Part of the new project is a docker compose file
    * Run `sed -i "s|#user: '1000:1000'|user: '$(id -u):$(id -g)'|g" docker-compose.yaml` to set the correct user id and group id.
    * Start the needed services with `docker compose up -d`

4. Install OpenDXP and initialize the DB
    `docker compose exec php vendor/bin/opendxp-install`
    * When asked for admin user and password: Choose freely
    * This can take a while, up to 20 minutes
    * If you select to install the SimpleBackendSearchBundle please make sure to add the `opendxp_search_backend_message` to your `.docker/supervisord.conf` file inside value for 'command' like `opendxp_maintenance` already is. With DDEV, add it to the `messenger-consume` daemon in `.ddev/config.yaml`.

5. Run the tests and the static analysis:
   * `docker compose run --user=root --rm test-php chown -R $(id -u):$(id -g) var/ public/var/`
   * `docker compose run --rm test-php vendor/bin/opendxp-test install`
   * `docker compose run --rm test-php vendor/bin/pest`
   * `docker compose run --rm test-php vendor/bin/opendxp-test analyse .`
   * The [OpenDXP testkit](https://github.com/open-dxp/docker-testkit) runs the same tests in an isolated slot, if you use it.
   * Tests are written with [Pest](https://pestphp.com) on top of [open-dxp/test-foundation](https://github.com/open-dxp/test-foundation), see its README
   * Code style: `docker compose exec php vendor/bin/php-cs-fixer fix`

6. :heavy_check_mark: DONE - You can now visit your OpenDXP instance:
    * The frontend: <http://localhost>
    * The admin interface, using the credentials you have chosen above:
      <http://localhost/admin>

## DDEV

The project also ships a [DDEV](https://ddev.com) configuration in `.ddev/`. It runs the same PHP version, database, workers and
nginx rules as the Docker setup above.

```bash
ddev start
ddev composer install
ddev exec vendor/bin/opendxp-install
ddev restart # starts the messenger workers and the maintenance job, which need the installed application
```

Tests and static analysis run against a separate `opendxp_test` database that DDEV creates on start. DDEV runs
the application in `dev`, so these commands set the `test` environment themselves:

```bash
ddev exec APP_ENV=test vendor/bin/opendxp-test install
ddev exec APP_ENV=test vendor/bin/pest
ddev exec APP_ENV=test vendor/bin/opendxp-test analyse .
```

## AI agents

The project is prepared for coding agents with [Symfony AI Mate](https://symfony.com/doc/current/ai/components/mate.html)
and the [OpenDXP Mate extension](https://github.com/open-dxp/mate-extension). Its tools answer from the booted
application: the bundles, the data model, the configuration, the document types and areabricks. Its skills tell the agent
which OpenDXP mechanism fits a task.

* `AGENTS.md` holds the instructions for every agent, `CLAUDE.md` imports it for Claude Code.
* After every `composer install` and `composer update`, the Composer plugin of Mate runs `vendor/bin/mate discover`.
  It installs the skills into `.agents/skills` and `.claude/skills` and refreshes the block that Mate manages in
  `AGENTS.md`. Commit these changes, so that changed skills show up in review.
* The agent runs Mate through the `php` container: `docker compose exec -T php vendor/bin/mate tools:list`

Mate and its extensions are development dependencies. Never deploy them.

### Optional: Symfony tools for the agent

The [Symfony extension](https://symfony.com/doc/current/ai/components/mate.html) of Mate adds tools that read the
container and the profiler, such as `symfony-services` and `symfony-profiler-list`. The `mate-opendxp-dev` skill uses them
when they are installed:

```bash
docker compose exec php composer require --dev symfony/ai-symfony-mate-extension
docker compose exec php vendor/bin/mate discover
```

### Using Mate with DDEV

Set the command in `mate/config.php`:

```php
->set('mate.invocation', 'ddev exec vendor/bin/mate')
```

Then run `ddev exec vendor/bin/mate discover` to write the new command into `AGENTS.md`.

***

## Upstream Origin & Version Transparency
This project is a fork of [Pimcore Skeleton 2024.x](https://github.com/pimcore/skeleton/tree/a7a52d4fd580cdcdeae26a9f148203e721fee9c7), which is © Pimcore GmbH and licensed under GPLv3.

## License
Licensed under the GNU General Public License v3.0 (GPLv3). For details, please see [LICENSE.md](LICENSE.md).

## Copyright
© Pimcore GmbH  
© 2025 OpenDXP Contributors — GPLv3

## Trademarks
Pimcore® is a registered [trademark](https://www.trademarkelite.com/europe/trademark/trademark-detail/009309841/PIMCORE) of Pimcore GmbH.
Any use of the Pimcore® mark in this repository is purely descriptive to identify the original upstream project. 

***

## Contact
For inquiries, suggestions, or contributions, feel free to reach us at contact@opendxp.ch.

## About
OpenDXP is a community-driven project initiated by [DACHCOM.DIGITAL](https://www.dachcom.com/de-ch) (Rheineck, Switzerland) and maintained by its community and contributors.
OpenDXP is independent and not affiliated with Pimcore GmbH.

The project’s purpose is to preserve and maintain a GPLv3‑licensed codebase for community use.

It is **not positioned as a competitor** to products or services of Pimcore GmbH and does **not** purport to replace or supersede any Pimcore offering.   
