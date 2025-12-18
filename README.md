# SPK Penilaian Kinerja Pegawai Non ASN

Sistem Pendukung Keputusan untuk Penilaian Kinerja Pegawai Non ASN DISKOMINFOTIKSAN Kabupaten Sumbawa menggunakan metode MFEP dan SAW.

## Teknologi
- Laravel 12
- Bootstrap 5
- MySQL
- PHP 8.x

## Instalasi

1. **Buat database MySQL:**
```sql
CREATE DATABASE spk_pegawai;
```

2. **Konfigurasi .env:**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_pegawai
DB_USERNAME=root
DB_PASSWORD=
```

3. **Jalankan migrasi dan seeder:**
```bash
php artisan migrate
php artisan db:seed
```

4. **Jalankan aplikasi:**
```bash
php artisan serve
```

5. **Akses aplikasi:**
- URL: http://localhost:8000

## Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@spk.com | password |
| Kepala Instansi | kepala@spk.com | password |

## Fitur

### Admin
- Manajemen Data Pegawai
- Manajemen Kriteria & Sub Kriteria
- Input Penilaian Kinerja
- Perhitungan MFEP & SAW
- Export Laporan PDF

### Kepala Instansi
- Lihat Hasil Penilaian
- Perbandingan MFEP & SAW
- Download Laporan PDF
