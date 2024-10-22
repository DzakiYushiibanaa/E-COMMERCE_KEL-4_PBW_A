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
![class diagram e-commerce](https://github.com/user-attachments/assets/923e2a66-268f-4632-95ec-0b8e5f4cd9db)
#### Metode di Setiap Kelas:
- User_Pengguna memiliki metode register(), login(), dan updateProfile() untuk mengelola pengguna.
- Keranjang memiliki metode addItem(), removeItem(), clearCart(), dan getTotalPrice() untuk mengelola item di keranjang.
- Item_Keranjang memiliki metode updateQuantity() untuk memperbarui jumlah item di keranjang.
- Produk memiliki metode updateStock() dan updatePrice() untuk mengelola stok dan harga produk.
- Pesanan memiliki metode createOrder(), cancelOrder(), dan getOrderDetails() untuk pengelolaan pesanan.
- Detail_Pesanan memiliki metode updateDetails() untuk memperbarui detail pesanan.
- Pembayaran memiliki metode processPayment(), refundPayment(), dan updatePaymentStatus() untuk memproses pembayaran.
- Pengiriman memiliki metode scheduleDelivery(), updateDeliveryStatus(), dan trackDelivery() untuk mengelola pengiriman.

