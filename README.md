# Sistem Reminder Service Kendaraan

Sistem ini adalah aplikasi berbasis Laravel untuk mengelola reminder service kendaraan. Aplikasi ini mengintegrasikan WhatsApp menggunakan layanan Wablas untuk mengirimkan pesan reminder kepada pelanggan.

## Fitur Utama

-   Manajemen data perbaikan kendaraan
-   Sistem reminder otomatis
-   Integrasi WhatsApp menggunakan Wablas
-   Dashboard admin untuk monitoring dan pengiriman reminder manual

## Persyaratan Sistem

-   PHP >= 8
-   Composer
-   MySQL atau MariaDB
-   Node.js dan NPM (untuk kompilasi asset)

## Instalasi

1. Clone repositori ini:

    ```
    git clone -b test https://github.com/hycallf/tomo-master
    cd tomo-master
    ```

2. Instal dependensi PHP:

    ```
    composer install
    npm install
    ```

3. Salin file `.env.example` menjadi `.env`:

    ```
    cp .env.example .env
    ```

4. Generate application key:

    ```
    php artisan key:generate
    ```

5. Konfigurasi database di file `.env`:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database
    DB_USERNAME=username
    DB_PASSWORD=password
    ```

6. Jalankan migrasi database:

    ```
    php artisan migrate
    ```

7. (Opsional) Jalankan seeder untuk mengisi data awal:
    ```
    php artisan db:seed
    ```

## Konfigurasi Wablas

1. Daftar dan dapatkan API token dari [Wablas](https://wablas.com/).

2. Tambahkan konfigurasi Wablas di file `.env`:

    ```
    WABLAS_API_TOKEN=your_wablas_token
    WABLAS_URL=https://your-wablas-domain.com
    ```

3. Pastikan Anda telah menambahkan konfigurasi Wablas di `config/services.php`:
    ```php
    'wablas' => [
        'token' => env('WABLAS_TOKEN'),
        'url' => env('WABLAS_URL'),
    ],
    ```

## Penggunaan

1. Jalankan server development:

    ```
    php artisan serve
    ```

2. Akses aplikasi melalui browser: `http://localhost:8000`

3. Login menggunakan kredensial default:

    Administator Level 0(all feature)

    - Email: administrator@gmail.com
    - Password: password

    Admin Level 1 (all except CRUD master user, transaksi)

    - Email: admin@gmail.com
    - Password: password

    Pekerja (edit progres perbaikan)

    - Email: pekerja@gmail.com
    - Password: password

    Pengguna (melihat data kendaraanku dan perbaikan yang telah dilakukan)
    -email : bisa daftar sendiri
    -password : bisa daftar sendiri

## Kustomisasi

-   Pengaturan aplikasi dapat diubah melalui panel admin di menu Settings.
-   Template pesan reminder dapat disesuaikan di `app/Http/Controllers/ReminderController.php`.

## Troubleshooting

Jika Anda mengalami masalah saat instalasi atau penggunaan, coba langkah-langkah berikut:

1. Pastikan semua persyaratan sistem terpenuhi.
2. Hapus cache aplikasi:
    ```
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
    ```
3. Regenerate autoload files:
    ```
    composer dump-autoload
    ```
4. Jika ada masalah dengan database, coba reset dan migrate ulang:
    ```
    php artisan migrate:fresh --seed
    ```

## Kontribusi

Kontribusi selalu diterima. Silakan buat pull request atau laporkan issue jika Anda menemukan bug atau memiliki saran perbaikan.

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
