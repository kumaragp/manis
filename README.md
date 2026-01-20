# Manis

Manis adalah website yang dirancang untuk memudahkan perusahaan dalam melakukan manajemen inventaris alat, mulai dari pencatatan data alat, pemantauan ketersediaan, pengelolaan penggunaan, perawatan serta penjualan alat.

Perusahaan dapat meminimalkan kesalahan pencatatan manual, mempercepat proses administrasi inventaris, serta memastikan setiap alat tercatat dengan jelas termasuk status, jumlah, dan riwayat penggunaannya. Sistem ini membantu meningkatkan efisiensi operasional, transparansi data, dan pengambilan keputusan berbasis informasi yang akurat.


## Features

**User Karyawan**
- **Peminjaman Alat**: Karyawan dapat melakukan peminjaman alat secara daring melalui sistem.
- **Pengembalian Alat**: Karyawan dapat melakukan pengembalian alat secara daring tanpa harus datang langsung ke tempat peminjaman.
- **Pelaporan Alat**: Karyawan dapat melaporkan kerusakan alat secara daring kepada admin. 

**User Admin**
- **Memantau Peminjaman Alat**:  Admin dapat memantau status peminjaman alat yang sedang digunakan oleh karyawan.
- **Daftar Alat**: Admin dapat menambahkan, memperbarui, dan menghapus data alat.
- **Pengadaan Alat**: Admin dapat mencatat rencana pengadaan alat sebelum alat ditambahkan ke sistem.
- **Penjualan Alat**: Admin dapat mencatat penjualan alat yang sudah tidak digunakan.
- **Manajemen Laporan Kerusakan Alat**: Admin dapat mencatat kerusakan alat dan memantau laporan kerusakan yang disampaikan oleh karyawan.
- **Daftar Karyawan**: Admin dapat menambahkan dan mengelola data karyawan agar dapat mengakses sistem.
- **Cetak Laporan**: Admin dapat mencetak laporan penjualan dan perawatan alat dengan dua metode, yaitu:


## Tech Stack

- **Backend**: Laravel
- **Frontend**: Tempalating Blade Engine, TailwindCSS for Styling
- **Database**: MySQL
- **Others**: Livewire, Javascript


## Demo Project

Web saat ini masih dalam pengembangan (local)


## Preview

### 1. User Karyawan

##### Daftar Alat
![Daftar Alat](https://github.com/user-attachments/assets/00d7d165-ae65-4863-a897-a5b052d487eb)

##### Riwayat Peminjaman
![Riwayat Peminjaman](https://github.com/user-attachments/assets/7a302006-a6ad-4da1-b854-32bacb84ce5b)

---

### 2. User Admin

##### Riwayat Peminjaman
![Dashboard Riwayat Peminjaman](https://github.com/user-attachments/assets/d767d9b6-251f-4e75-bd29-f6401ebd05c9)

##### Daftar Alat
![Dashboard Daftar ALat](https://github.com/user-attachments/assets/ad8c8493-90ef-41f0-97de-8efafe6b7381)

##### Pengadaan Alat
![Dashboard Pengadaan Alat](https://github.com/user-attachments/assets/c2102bff-b177-4678-8fbd-62005c096061)

##### Penjualan Alat
![Dashboard Penjualan Alat](https://github.com/user-attachments/assets/6f46840d-92f5-42cc-9703-2ff320655a00)

##### Perawatan Alat
![Dashboard Perawatan Alat](https://github.com/user-attachments/assets/01b11395-0ea6-4fff-846f-9679fb0d5acb)

##### Daftar Karyawan
![Dashboard Daftar Karyawan](https://github.com/user-attachments/assets/940b0283-69e0-4936-a533-c0404210a2e0)


## Panduan Instalasi
Ikuti langkah-langkah berikut untuk menginstal Manis di lokal Anda:
<br>Nb. Pastikan lokal server Anda sudah berjalan, bisa menggunakan XAMPP, Laragon, atau sejenisnya.

1. **Clone Repository**
   ```bash
   git clone https://github.com/kumaragp/manis.git
   
2. **Masuk ke Direktori Proyek Setelah repositori ter-clone**
   ```bash
   cd manis
    
3. **Install Dependencies Pastikan Anda sudah menginstal Composer dan Node.js**
   ```bash
   composer install
   npm install
   
4. **Konfigurasi .env**
   ```bash
   cp .env.example .env
   
5. **Generate Key Aplikasi**
   ```bash
   php artisan key:generate
   
6. **Migrasi Database**
   Karena adanya foreign key, jalankan perintah migrasi berikut secara berurutan untuk memastikan migrasi berhasil:
   ```bash
   php artisan migrate
   
7. **Install NPM Assets**
   ```bash
   npm run dev
   
8. **Jalankan Server**
   ```bash
   php artisan serve

9. Akses aplikasi melalui browser di alamat http://localhost:8000.


## Issue
Jika Anda menemui masalah atau membutuhkan bantuan lebih lanjut, silakan buka issue di GitHub atau hubungi saya.


## Authors

- [@kumaragp](https://github.com/kumaragp)
- [@rindiantikaaa](https://github.com/rindiantikaaa)
- [@izzanannafi](https://github.com/Izzannafi)
