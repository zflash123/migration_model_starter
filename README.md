## Beberapa Catatan Terkait Penggunaan Repository Ini
1. Silahkan melakukan kloning pada repository ini dengan meng-copy url repository

2. Setelah melakukan kloning ketikan di terminal perintah berikut. Bertujuan agar APP KEY update otomatis dan vendor akan terinstal serta .env akan terbentuk
     ```shell
        composer update
     ```
     ```shell
        cp .env.example .env
     ```
     ```shell
        php artisan key:generate
     ```
