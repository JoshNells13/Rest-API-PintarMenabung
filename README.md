📌 REST API – PintarMenabung

Backend aplikasi PintarMenabung dibangun menggunakan Laravel dan menyediakan REST API untuk manajemen keuangan pribadi. API ini mencakup fitur otentikasi, pengelolaan dompet, pencatatan transaksi, hingga laporan keuangan.

🔑 Authentication

POST /api/auth/register – Registrasi user baru

POST /api/auth/login – Login user & generate token (Laravel Sanctum)

POST /api/auth/logout – Logout & revoke token

💱 Currency & Category

GET /api/currencies – Mendapatkan semua mata uang

GET /api/categories – Mendapatkan semua kategori (Income & Expense)

👛 Wallet

POST /api/wallets – Tambah dompet

PUT /api/wallets/:walletId – Update dompet

DELETE /api/wallets/:walletId – Hapus dompet

GET /api/wallets – Daftar semua dompet milik user

GET /api/wallets/:walletId – Detail dompet tertentu

💸 Transaction

POST /api/transactions – Tambah transaksi (income/expense)

DELETE /api/transactions/:transactionId – Hapus transaksi

GET /api/transactions – Ambil daftar transaksi (support pagination & filter bulan/tahun)

📊 Financial Reports

GET /api/reports/summary-by-category/expense – Ringkasan transaksi berdasarkan kategori pengeluaran

GET /api/reports/summary-by-category/income – Ringkasan transaksi berdasarkan kategori pemasukan
