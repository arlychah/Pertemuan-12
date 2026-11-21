# Kasus 02 — Relasi Buku dan Kategori

**Level:** Menengah  
**Fokus:** Migration, foreign key, Eloquent relationship, belongsTo, hasMany, eager loading.

## Tujuan

Memahami relasi one-to-many: satu kategori memiliki banyak buku, dan setiap buku dimiliki satu kategori.

## Instalasi

Buat database `bug_battle_case_02` dan sesuaikan konfigurasi database pada `.env`. Dari direktori proyek, jalankan:

```bash
php artisan optimize:clear
php artisan migrate
php artisan db:seed --class=CategorySeeder
php artisan serve
```

Buka `http://127.0.0.1:8000/books`.

## Gejala yang Diselidiki

1. Migrasi tabel buku dapat gagal atau relasinya tidak terjamin.
2. Daftar buku gagal mengambil kategori.
3. Nama kategori tidak tampil dengan benar.
4. Form buku tidak menampilkan pilihan kategori dengan benar.

## Tugas

- Perbaiki foreign key `category_id`.
- Perbaiki relasi pada kedua Model.
- Perbaiki pemanggilan relasi pada Controller dan Blade.
- Pastikan satu kategori dapat memiliki banyak buku.
- Uji data buku dengan beberapa kategori.
