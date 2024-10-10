1. Install PHP dependencies:
    ```bash
    composer install
    ```

2. Copy the `.env.example` file and rename it to `.env`:
    ```bash
    cp .env.example .env
    ```

3. Generate application key:
    ```bash
    php artisan key:generate
    ```

4. Run database migrations - seeder:
    ```bash
    php artisan migrate:refresh --seed
    ```

5. Start the development server:
    ```bash
    php artisan serve
    ```

6. Login:
    ```bash
    username : admin@email.com
    password : password
    ```

Built with 💙 by Budi Prastyo <budi@prastyo.com>