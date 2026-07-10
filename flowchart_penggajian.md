# Flowchart Sistem Aplikasi Penggajian

Dokumen ini menjelaskan alur kerja (workflow) dari aplikasi penggajian karyawan, mulai dari pengelolaan master data (Golongan & Pegawai) hingga proses perhitungan gaji bulanan.

## Diagram Alur Kerja (Flowchart)

Berikut adalah diagram alur kerja menggunakan Mermaid. VS Code akan merender ini sebagai diagram visual jika Anda memiliki ekstensi *Markdown Preview Mermaid Support* atau membukanya di editor Markdown.

```mermaid
graph TD
    Start([Mulai]) --> Login[Akses Dashboard]
    Login --> Menu{Pilih Menu Utama}
    
    %% KELOLA GOLONGAN
    Menu -->|Data Golongan| GolonganList[Tampilkan Daftar Golongan]
    GolonganList --> GolonganCRUD{Pilih Aksi}
    GolonganCRUD -->|Tambah/Edit| GolonganForm[Input Kode, Nama, Gaji Pokok, Tunjangan Makan & Transport]
    GolonganForm --> GolonganValidate{Validasi Input}
    GolonganValidate -->|Gagal| GolonganForm
    GolonganValidate -->|Sukses| GolonganSave[Simpan Data Golongan]
    GolonganSave --> GolonganList
    GolonganCRUD -->|Hapus| GolonganCheck{Apakah Golongan memiliki Pegawai?}
    GolonganCheck -->|Ya| GolonganError[Error: Golongan sedang digunakan oleh pegawai]
    GolonganCheck -->|Tidak| GolonganDelete[Hapus Data Golongan]
    GolonganDelete --> GolonganList
    GolonganError --> GolonganList

    %% KELOLA PEGAWAI
    Menu -->|Data Pegawai| PegawaiList[Tampilkan Daftar Pegawai]
    PegawaiList --> PegawaiCRUD{Pilih Aksi}
    PegawaiCRUD -->|Tambah/Edit| PegawaiForm[Input NIP, Nama, Email, Alamat, dll & Pilih Golongan]
    PegawaiForm --> PegawaiValidate{Validasi Input}
    PegawaiValidate -->|Gagal| PegawaiForm
    PegawaiValidate -->|Sukses| PegawaiSave[Simpan Data Karyawan]
    PegawaiSave --> PegawaiList
    PegawaiCRUD -->|Hapus| PegawaiDelete[Hapus Data Pegawai & Riwayat Gaji otomatis terhapus CASCADE]
    PegawaiDelete --> PegawaiList

    %% PROSES PENGGAJIAN
    Menu -->|Transaksi Gaji| GajiList[Tampilkan Daftar Transaksi Gaji]
    GajiList --> GajiCRUD{Pilih Aksi}
    GajiCRUD -->|Input Gaji Baru| GajiForm[Pilih Pegawai & Periode Bulan/Tahun]
    GajiForm --> GajiSystem[Sistem Otomatis Mengambil Gaji Pokok & Tunjangan dari Golongan Pegawai]
    GajiSystem --> GajiInput[Input Tunjangan Lainnya & Potongan Manual]
    GajiInput --> GajiCalc[Sistem Menghitung: Gaji Bersih = Total Pendapatan - Total Potongan]
    GajiCalc --> GajiSave[Simpan Transaksi Gaji: Status Draft / Diproses / Selesai]
    GajiSave --> GajiList
    
    %% LAPORAN
    Menu -->|Laporan| LaporanView[Tampilkan Statistik/Ringkasan Gaji Bulanan]
```

## Penjelasan Alur Kerja

1. **Master Data Golongan**: 
   * Merupakan data master yang berisi komponen standar keuangan (Gaji Pokok, Tunjangan Makan, Tunjangan Transport).
   * Data ini tidak dapat dihapus jika masih ada pegawai yang terhubung ke golongan tersebut (`onDelete('restrict')`).

2. **Master Data Pegawai**:
   * Setiap pegawai wajib dihubungkan ke salah satu golongan agar sistem tahu basis gaji pokok dan tunjangannya.

3. **Proses Penggajian (Komponen Gaji)**:
   * Saat admin membuat input gaji baru untuk pegawai tertentu pada bulan/tahun tertentu, sistem otomatis mengambil default `gaji_pokok`, `tunjangan_makan`, dan `tunjangan_transport` berdasarkan golongan pegawai tersebut.
   * Admin kemudian bisa menambahkan komponen tambahan seperti *Tunjangan Lainnya* atau *Potongan Absensi*.
   * Sistem menghitung rumus:
     $$\text{Gaji Bersih} = (\text{Gaji Pokok} + \text{Tunjangan Makan} + \text{Tunjangan Transport} + \text{Tunjangan Lainnya}) - (\text{Potongan Absensi} + \text{Potongan Lainnya})$$
   * Data disimpan dengan status tertentu (`draft`, `diproses`, atau `selesai`).
