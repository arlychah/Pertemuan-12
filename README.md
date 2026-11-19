## Kasus 01 — CRUD Manajemen Buku

Aplikasi Laravel sederhana untuk melihat, menambah, dan menghapus data buku.

### Persiapan database

Buat database MySQL `bug_battle_case_01`, lalu atur koneksi pada `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bug_battle_case_01
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan aplikasi:

```bash
php artisan optimize:clear
php artisan migrate
php artisan serve
```

Buka `http://127.0.0.1:8000/books`. Form buku mewajibkan judul, penulis, dan tahun terbit; hapus buku dilakukan melalui tombol di daftar.

### Pengujian

```bash
php artisan test --compact
```
