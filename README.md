# Janji

Saya Muhammad Bintang Eighista dengan NIM 2304137 mengerjakan TP 7 dalam mata kuliah Desain
dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan
seperti yang telah dispesifikasikan. Aamiin.

# Movie Review Application

Aplikasi web sederhana untuk mengelola review film, dibuat menggunakan PHP dan MySQL.

## Struktur Proyek

- movie-review-app/
- ├── config/
- │ └── db.php # Konfigurasi database
- ├── view/
- │ ├── user/ # Tampilan manajemen user
- │ │ ├── index.php # Daftar user
- │ │ ├── add.php # Form tambah user
- │ │ ├── edit.php # Form edit user
- │ │ └── delete.php # Handler hapus user
- │ ├── movie/ # Tampilan manajemen movie
- │ │ ├── index.php # Daftar movie
- │ │ ├── add.php # Form tambah movie
- │ │ ├── edit.php # Form edit movie
- │ │ └── delete.php # Handler hapus movie
- │ └── review/ # Tampilan manajemen review
- │ ├── index.php # Daftar review
- │ ├── add.php # Form tambah review
- │ ├── edit.php # Form edit review
- │ └── delete.php # Handler hapus review
- ├── database/
- │ └── db_moviereview.sql # Skema database
- ├── index.php # File utama aplikasi
- └── README.md # Dokumentasi

## Desain Database

### Tabel

1. **users**

   - id_user (PK)
   - username
   - email
   - registered_at

2. **movies**

   - id_movie (PK)
   - title
   - genre
   - release_year
   - director

3. **reviews**
   - id_review (PK)
   - id_user (FK)
   - id_movie (FK)
   - rating
   - comment
   - review_date

## Alur Aplikasi

1. **Navigasi**

   - Aplikasi menggunakan satu entry point di `index.php`
   - Halaman dikontrol melalui parameter URL:
     - `?page=user|movie|review`
     - `?action=add|edit|delete`

2. **Manajemen User**

   - Menampilkan semua user dengan fitur pencarian
   - Menambah user baru
   - Edit data user
   - Hapus user (dengan konfirmasi)

3. **Manajemen Movie**

   - Menampilkan semua movie dengan fitur pencarian
   - Menambah movie baru
   - Edit data movie
   - Hapus movie (dengan konfirmasi)

4. **Manajemen Review**
   - Menampilkan semua review beserta detail user & movie
   - Menambah review baru (pilih user & movie)
   - Edit review
   - Hapus review (dengan konfirmasi)

## Fitur

- **CRUD Operations**

  - Create: Tambah data baru
  - Read: Lihat & cari data
  - Update: Edit data yang sudah ada
  - Delete: Hapus data

- **User Interface**

  - Desain responsif menggunakan Bootstrap
  - Menu navigasi dengan status aktif
  - Fitur pencarian data
  - Validasi form
  - Pesan sukses/gagal
  - Dialog konfirmasi

- **Keamanan Data**
  - Koneksi database menggunakan PDO
  - Query dengan prepared statement
  - Validasi input
  - Perlindungan dari XSS

## Kebutuhan

- PHP 7.4+
- MySQL 5.7+
- Bootstrap 5.3.0
- Web server (Apache/Nginx)

## Cara Instalasi

1. Clone repository ke direktori web server Anda
2. Import skema database:
   mysql -u root -p < database/db_moviereview.sql
3. Atur koneksi database di `config/db.php`
4. Akses aplikasi melalui browser

## Cara Penggunaan

1. **Manajemen User**

- Masuk ke menu "Users"
- Tambah/Edit/Hapus user
- Cari user berdasarkan username/email

2. **Manajemen Movie**

- Masuk ke menu "Movies"
- Tambah/Edit/Hapus movie
- Cari movie berdasarkan judul/sutradara

3. **Manajemen Review**

- Masuk ke menu "Reviews"
- Tambah review dengan memilih user dan movie
- Edit/Hapus review yang ada
- Lihat semua review beserta detail user dan movie

## Penanganan Error

- Error koneksi database
- Gagal melakukan operasi CRUD
- Validasi input tidak valid
- Data tidak ditemukan
- Tampil pesan sukses/gagal

## Screenshot
![image](https://github.com/user-attachments/assets/729621cf-53cc-49a1-84d2-46ea64185c4f)
![image](https://github.com/user-attachments/assets/cccb6aac-8afb-4204-a8f9-be90d393dd1f)
![image](https://github.com/user-attachments/assets/4baf3858-edd0-4dd8-a031-9d1ff52c99b4)
![image](https://github.com/user-attachments/assets/d85ff8fc-da16-46aa-abf8-0a15a82538b1)
![image](https://github.com/user-attachments/assets/334c194d-fd91-4b60-9cf9-7a87b04b3e5a)
![image](https://github.com/user-attachments/assets/ab9aa986-b412-41b6-8bf6-870eb82ee17f)
![image](https://github.com/user-attachments/assets/edcd5cad-0a69-458c-ac19-2c71d522b56b)
![image](https://github.com/user-attachments/assets/7a9ad566-16bc-4aa5-91f2-2bc59dad18a6)
