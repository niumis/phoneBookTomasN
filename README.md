## Installation

1. Build/run containers with environment

   1. Go to project
    ```bash
   $ cd to project root
   $ cd docker
   ```
   2. Set environment (default dev) to `docker/.env` variable `APP_ENV=prod` or `APP_ENV=dev`
   3. Setup containers (without `-d` flag need open new terminal)
   ```bash
   $ docker-compose up
    ```
   4. Setup containers in background
   ```bash
   $ docker-compose up -d
   ```
2. Load assets

    ```bash
   $ docker-compose run php-fpm yarn
   ```
   1. If environment `prod`
   ```bash
   $ docker-compose run php-fpm yarn run encore prod
   ```
   2. If environment `dev`
   ```bash
   $ docker-compose run php-fpm yarn run encore dev
   ```

3. Prepare data (if environment `dev`)

   1. Load fixtures
   
   ```bash
   $ docker-compose run php-fpm bin/console doctrine:fixtures:load -n
   ```
   
   2. Can logged with users (username and password are the same): `user1`, `user2`, `user3`
 
4. Run tests (if on first run fails, execute one more)

    ```bash
   $ docker-compose run php-fpm phpunit
   ```

5. Access to site [localhost](http://127.0.0.1), Enjoy :-)
