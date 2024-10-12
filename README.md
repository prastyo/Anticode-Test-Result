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

    username : operator@email.com
    password : password
    ```
![Database schema](https://raw.githubusercontent.com/prastyo/Anticode-Test-Result/refs/heads/main/master_desa.png)
Database Master Desa [master_desa.sql](https://raw.githubusercontent.com/prastyo/Anticode-Test-Result/refs/heads/main/master_desa.sql)

Demo video [![Anticode](https://img.youtube.com/vi/qK8JVEwVSKU/0.jpg)](https://youtu.be/qK8JVEwVSKU)

Demo live : [https://anticode-test.prastyo.com](https://anticode-test.prastyo.com)

Built with 💙 by Budi Prastyo <budi@prastyo.com>