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
                server_version: '%env(default:8.0:DATABASE_SERVER_VERSION)%'
```

If you're using a different database version, you can override this in your `.env` or `.env.local`:

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
1. Initialize the skeleton project using the `open-dxp/opendxp` image
``docker run -u `id -u`:`id -g` --rm -v `pwd`:/var/www/html open-dxp/opendxp:php8.3-latest composer create-project open-dxp/skeleton my-project``

2. Go to your new project
`cd my-project/`

3. Part of the new project is a docker compose file
    * Run `sed -i "s|#user: '1000:1000'|user: '$(id -u):$(id -g)'|g" docker-compose.yaml` to set the correct user id and group id.
    * Start the needed services with `docker compose up -d`

4. Install OpenDXP and initialize the DB
    `docker compose exec php vendor/bin/opendxp-install`
    * When asked for admin user and password: Choose freely
    * This can take a while, up to 20 minutes
    * If you select to install the SimpleBackendSearchBundle please make sure to add the `opendxp_search_backend_message` to your `.docker/supervisord.conf` file inside value for 'command' like `opendxp_maintenance` already is.

5. Run codeception tests:
   * `docker compose run --user=root --rm test-php chown -R $(id -u):$(id -g) var/ public/var/`
   * `docker compose run --rm test-php vendor/bin/opendxp-install -n`
   * `docker compose run --rm test-php vendor/bin/codecept run -vv`

6. :heavy_check_mark: DONE - You can now visit your OpenDXP instance:
    * The frontend: <http://localhost>
    * The admin interface, using the credentials you have chosen above:
      <http://localhost/admin>

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
