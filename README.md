# E-COMMERCE_KEL-4_PBW_A
## Anggota Kelompok 4 :
Nama & NPM
- Jati Rahmatulloh - 4522210039
- Reno Fatullah Rifai - 4522210021
- Dzaki Yushiibanaa - 4522210041

# DESKRIPSI
#### Renzati.Shop adalah platform e-commerce yang dikhususkan untuk penjualan laptop dan aksesori komputer. Platform ini dirancang untuk memberikan pengalaman berbelanja yang mudah dan nyaman bagi konsumen yang mencari perangkat komputasi berkualitas. Dengan antarmuka yang intuitif dan fitur-fitur komprehensif, kami memastikan proses pembelian laptop menjadi lebih efisien dan menyenangkan.

## USE CASE 
![use case e-commerce drawio](https://github.com/user-attachments/assets/390aa46e-8be3-4e47-990d-25aef1c48ce2)
#### terdapat 2 aktor:
- User (Pengguna/Pelanggan)
- Admin

#### Use Case untuk User:

- Login - User dapat masuk ke sistem
- Register - User dapat mendaftar akun baru
- Melihat Produk - User dapat melihat daftar produk yang tersedia
- Checkout - User dapat melakukan pembayaran produk
- Lihat Detail Pesanan - User dapat melihat detail pesanan yang dibuat
- Cek Status Pesanan - User dapat mengecek status pesanan
- Menambah Barang ke Keranjang - User dapat memasukkan produk ke keranjang belanja
- Logout - User dapat keluar dari sistem

#### Use Case untuk Admin:

- Login - Admin dapat masuk ke sistem
- Melihat Laporan Penjualan - Admin dapat melihat laporan penjualan
- Mengelola Produk - Admin dapat menambah/mengubah/menghapus produk
- Konfirmasi Pesanan - Admin dapat mengkonfirmasi pesanan dari user
- Logout - Admin dapat keluar dari sistem

## CLASS DIAGRAM
![class diagram e-commerce](https://github.com/DzakiYushiibanaa/E-COMMERCE_KEL-4_PBW_A/blob/374b9137ec002099ec325520071adf0455d8930f/Image/Class%20Diagram.png)
#### Metode di Setiap Kelas:
Metode di Setiap Kelas:

- Users:
register(): Metode untuk mendaftarkan pengguna baru.
login(): Metode untuk otentikasi pengguna agar dapat mengakses sistem.
updateProfile(): Metode untuk memperbarui data profil pengguna, seperti nama, email, dan password.

- Carts:
addItem(): Menambahkan item (produk) ke keranjang belanja.
removeItem(): Menghapus item tertentu dari keranjang belanja.
clearCart(): Menghapus semua item dalam keranjang belanja.
getTotalPrice(): Menghitung total harga semua item dalam keranjang.

- Cart_Items:
updateQuantity(): Memperbarui jumlah suatu produk yang ada dalam keranjang.

- Products:
updateStock(): Memperbarui jumlah stok produk setelah terjadi transaksi.
updatePrice(): Mengubah harga suatu produk.

- Orders:
createOrder(): Membuat pesanan baru berdasarkan data dari keranjang belanja.
cancelOrder(): Membatalkan pesanan sebelum diproses lebih lanjut.
getOrderDetails(): Mengambil rincian informasi pesanan, seperti produk, jumlah, dan harga.

- Order_Items:
updateDetails(): Memperbarui detail produk yang terkait dengan suatu pesanan (misalnya jumlah atau harga produk).

- Payments:
processPayment(): Memproses pembayaran pesanan melalui metode yang dipilih.
refundPayment(): Melakukan pengembalian uang jika terjadi pembatalan pesanan.
updatePaymentStatus(): Memperbarui status pembayaran (pending, completed, failed, refunded).

- Promos (Opsional):
applyPromo(): Metode untuk menerapkan promo ke pesanan tertentu.
removePromo(): Menghapus promo yang telah diterapkan.

## ERD Diagram
![ERD Diagram e-commerce](https://github.com/DzakiYushiibanaa/E-COMMERCE_KEL-4_PBW_A/blob/6e583c3fe1784f2a262ea9a84c94b029b6beae90/Image/ERD%20Diagram.png).
### Kardinalitas
- Users ke Carts (1 to 1):
Setiap pengguna hanya memiliki satu keranjang belanja.
Satu keranjang hanya dimiliki oleh satu pengguna.

- Carts ke Cart_Items (1 to Many):
Satu keranjang dapat memiliki banyak item.
Satu item hanya terkait dengan satu keranjang.

- Cart_Items ke Products (Many to 1):
Satu produk dapat muncul dalam banyak keranjang yang berbeda.
Satu item keranjang hanya terkait dengan satu produk.

- Carts ke Orders (1 to 1):
Setiap keranjang hanya dapat dikaitkan dengan satu pesanan.
Satu pesanan hanya berasal dari satu keranjang.

- Orders ke Order_Items (1 to Many):
Satu pesanan dapat memiliki banyak item pesanan (detail produk).
Setiap detail pesanan hanya terkait dengan satu pesanan.

- Order_Items ke Products (Many to 1):
Satu produk dapat muncul dalam banyak pesanan.
Satu detail pesanan hanya terkait dengan satu produk.

- Orders ke Payments (1 to 1):
Satu pesanan hanya dapat memiliki satu pembayaran.
Satu pembayaran hanya terkait dengan satu pesanan.

- Promos (Standalone Entity):
Promo tidak memiliki hubungan langsung dengan entitas lain, tetapi dapat diterapkan ke pesanan melalui logika sistem.
