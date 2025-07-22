# OpenDXP Project Skeleton 

This skeleton should be used by experienced OpenDXP developers for starting a new project from the ground up. 
If you are new to OpenDXP, it's better to start with our demo package, listed below 😉

## Getting started
```bash
COMPOSER_MEMORY_LIMIT=-1 composer create-project open-dxp/skeleton my-project
cd ./my-project
./vendor/bin/opendxp-install
```

- Point your virtual host to `my-project/public`
- [Only for Apache] Create `my-project/public/.htaccess` according to docs/Installation_and_Upgrade/System_Setup_and_Hosting/Apache_Configuration/ 
- Open https://your-host/admin in your browser
- Done! 😎

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
