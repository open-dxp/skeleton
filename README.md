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

Create the project. Docker is enough, you need no PHP on your machine:

```bash
docker run -u `id -u`:`id -g` --rm -v `pwd`:/var/www/html opendxp/opendxp:php8.3-latest composer create-project open-dxp/skeleton my-project
cd my-project
```

With PHP and Composer on your machine, `COMPOSER_MEMORY_LIMIT=-1 composer create-project open-dxp/skeleton my-project` does the same.

The project runs with Docker Compose or with DDEV. Both run the same PHP version, database, workers and nginx rules. Choose wisely.

### Docker

Your user must be allowed to run Docker and Docker Compose, and to change file permissions.

```bash
sed -i "s|#user: '1000:1000'|user: '$(id -u):$(id -g)'|g" docker-compose.yaml
docker compose up -d
docker compose exec php vendor/bin/opendxp-install
```

Open the frontend at <http://localhost> and the admin at <http://localhost/admin>.

### DDEV

```bash
ddev config --project-name=my-project
ddev start
ddev exec vendor/bin/opendxp-install
ddev restart # starts the messenger workers and the maintenance job, which need the installed application
```

Open the frontend at <https://my-project.ddev.site> and the admin at <https://my-project.ddev.site/admin>.

### Installation notes

- `opendxp-install` asks for the admin user and password. Choose them freely. The installation can take up to 20 minutes.
  - If you install the SimpleBackendSearchBundle, add `opendxp_search_backend_message` to the workers. 
    - With Docker, add it to the `command` in `.docker/supervisord.conf`, like `opendxp_maintenance`. 
    - With DDEV, add it to the `messenger-consume` daemon in `.ddev/config.yaml`.
- `.docker/nginx.conf` and `.ddev/nginx_full/nginx-site.conf` hold the same rules, see
  [Nginx Configuration](https://docs.opendxp.io/docs/core-framework/Installation_and_Upgrade/System_Setup_and_Hosting/Nginx_Configuration).

### Your own web server

- Run `./vendor/bin/opendxp-install`
- Point your virtual host to `my-project/public`
- [Only for Apache] Create `my-project/public/.htaccess` according to [Apache Configuration](https://docs.opendxp.io/docs/core-framework/Installation_and_Upgrade/System_Setup_and_Hosting/Apache_Configuration)
- [Only for Nginx] Configure the server according to [Nginx Configuration](https://docs.opendxp.io/docs/core-framework/Installation_and_Upgrade/System_Setup_and_Hosting/Nginx_Configuration)
- Open https://your-host/admin in your browser

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
DATABASE_SERVER_VERSION=10.11.13-MariaDB
```

## Tests and code style

Tests are written with [Pest](https://pestphp.com) on top of
[open-dxp/test-foundation](https://github.com/open-dxp/test-foundation), see its README. They run against a database of their own.
[Testing a Project](https://docs.opendxp.io/docs/core-framework/Development_Tools_and_Details/Testing/Testing_a_Project/)
shows how a project tests its own code and the bundles it uses.

### Docker

```bash
docker compose run --user=root --rm test-php chown -R $(id -u):$(id -g) var/ public/var/ # once
docker compose run --rm test-php vendor/bin/opendxp-test install
docker compose run --rm test-php vendor/bin/pest
docker compose run --rm test-php vendor/bin/opendxp-test analyse .
docker compose exec php vendor/bin/php-cs-fixer fix
```

### DDEV

DDEV creates the `opendxp_test` database on start. It runs the application in `dev`, so the test commands set the `test` environment themselves:

```bash
ddev exec APP_ENV=test vendor/bin/opendxp-test install
ddev exec APP_ENV=test vendor/bin/pest
ddev exec APP_ENV=test vendor/bin/opendxp-test analyse .
ddev exec vendor/bin/php-cs-fixer fix
```

The [OpenDXP testkit](https://github.com/open-dxp/docker-testkit) runs the same tests in an isolated slot, if you use it.

## AI agents

The project is prepared for coding agents with [Symfony AI Mate](https://symfony.com/doc/current/ai/components/mate.html)
and the [OpenDXP Mate extension](https://github.com/open-dxp/mate-extension). Its tools answer from the booted
application: the bundles, the data model, the configuration, the document types and areabricks. Its skills tell the agent
which OpenDXP mechanism fits a task.

Set Mate up once with `mate init` and `mate discover`. `mate init` creates `mate/`, adds its configuration to
`composer.json` and its instructions to `AGENTS.md`. It also creates a `CLAUDE.md` that imports `AGENTS.md` for Claude
Code. `mate discover` installs the skills into `.agents/skills` and `.claude/skills` and refreshes the instructions.
Run it again after every `composer install` and `composer update`.

Mate and its extensions are development dependencies. Never deploy them.

### Docker

When `mate init` asks for the command your agent runs Mate with, answer `docker compose exec -T php vendor/bin/mate`.

```bash
docker compose exec php vendor/bin/mate init
docker compose exec php vendor/bin/mate discover
```

### DDEV

When `mate init` asks for the command your agent runs Mate with, keep the proposed `ddev exec vendor/bin/mate`.

```bash
ddev exec vendor/bin/mate init
ddev exec vendor/bin/mate discover
```

### Optional: Symfony tools for the agent

The [Symfony extension](https://symfony.com/doc/current/ai/components/mate.html) of Mate adds tools that read the
container and the profiler, such as `symfony-services` and `symfony-profiler-list`. 
The `mate-opendxp-dev` skill uses them when they are installed.

#### Docker

```bash
docker compose exec php composer require --dev symfony/ai-symfony-mate-extension
docker compose exec php vendor/bin/mate discover
```

#### DDEV

```bash
ddev composer require --dev symfony/ai-symfony-mate-extension
ddev exec vendor/bin/mate discover
```

***

## Upstream Origin & Version Transparency
This project is a fork of [Pimcore Skeleton 2024.x](https://github.com/pimcore/skeleton/tree/a7a52d4fd580cdcdeae26a9f148203e721fee9c7), which is © Pimcore GmbH and licensed under GPLv3.

## License
Licensed under the GNU General Public License v3.0 (GPLv3). For details, please see [LICENSE.md](LICENSE.md).

## Copyright
© Pimcore GmbH  
© 2026 OpenDXP Contributors — GPLv3

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
