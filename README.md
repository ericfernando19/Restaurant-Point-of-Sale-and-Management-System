# 🍽️ Restaurant POS System (Laravel)

Sistem **Point of Sale (POS)** berbasis web yang dirancang untuk mendukung operasional restoran dengan alur kerja yang terstruktur dan role-based access. Sistem ini mencakup pengelolaan menu, pencatatan transaksi, manajemen pesanan untuk dapur, serta laporan penjualan.

---

## 🚀 Fitur Utama

### ✔️ Role-Based Access
- 👑 **Admin**  
  Kelola menu, user, kategori, dan laporan penjualan.
- 💰 **Kasir**  
  Input pesanan, proses pembayaran, dan cetak struk PDF.
- 👨‍🍳 **Koki**  
  Melihat daftar pesanan yang masuk dan memperbarui status pesanan.

---

### ✔️ Manajemen Menu
- Tambah, edit, dan hapus menu
- Kategori makanan & pengaturan harga

---

### ✔️ Transaksi Kasir
- Input pesanan pelanggan
- Hitung total otomatis
- Cetak struk (PDF)

---

### ✔️ Kitchen Order Display
- Koki hanya melihat daftar pesanan **Pending**
- Update status: `Pending → Processing → Done`

---

### ✔️ Laporan Penjualan
- Filter berdasarkan tanggal
- Rekap transaksi dan pendapatan harian

---

## 🏗️ Teknologi yang Digunakan

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel |
| Frontend | Blade + Bootstrap |
| Database | MySQL |
| Authentication | Laravel Breeze |
| PDF Generator | DOMPDF |

---

