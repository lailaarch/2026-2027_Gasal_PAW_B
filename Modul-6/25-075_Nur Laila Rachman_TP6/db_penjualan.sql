USE db_penjualan;
CREATE TABLE supplier (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(10) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  harga INT NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  supplier_id INT NOT NULL,
  CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id) REFERENCES supplier(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
  id VARCHAR(20) PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_transaksi DATE NOT NULL,
  keterangan TEXT,
  total INT NOT NULL DEFAULT 0,
  pelanggan_id VARCHAR(20) NOT NULL,
  CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
  transaksi_id INT NOT NULL,
  barang_id INT NOT NULL,
  harga INT NOT NULL,
  qty INT NOT NULL,
  PRIMARY KEY (transaksi_id, barang_id),
  CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_detail_barang FOREIGN KEY (barang_id) REFERENCES barang(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_bayar DATETIME NOT NULL,
  total INT NOT NULL,
  metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
  transaksi_id INT NOT NULL,
  CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE `user` (
  id_user TINYINT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(50) NOT NULL,
  alamat VARCHAR(150),
  hp VARCHAR(20),
  level TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB;

INSERT INTO supplier (nama,telp,alamat) VALUES
('Kopi Josjis','083629762875','Telang'),
('Suka suka GUE','080127523652','Surabaya'),
('Besok kita kesana','087762892677','Malang'),
('Acay','082887256783','Bangkalan'),
('Matcha House','082627626782','Lamongan');

INSERT INTO barang (kode_barang,nama_barang,harga,stok,supplier_id) VALUES
('CF001','Espresso',18000,100,1),
('CF002','Americano',20000,100,1),
('CF003','Cappuccino',25000,80,2),
('CF004','Cafe Latte',26000,80,2),
('CF005','Caramel Macchiato',32000,60,4),
('CF006','Mocha',29000,60,4),
('CF007','Matcha Latte',28000,50,5),
('CF008','Cold Brew',24000,70,1),
('CF009','Vanilla Latte',30000,50,4),
('CF010','Chocolate Milk',22000,60,3);

INSERT INTO pelanggan (id,nama,jenis_kelamin,telp,alamat) VALUES
('PLG001','Alya Putri','P','0874948597','Telang'),
('PLG002','Bima Pratama','L','080257497645','Sidoarjo'),
('PLG003','Citra Lestari','P','089366506738','Gresik'),
('PLG004','Daffa Ramadhan','L','082886489074','Surabaya'),
('PLG005','Eka Safitri','P','087263587782','Mojokerto'),
('PLG006','Farhan Akbar','L','080827638926','Surabaya'),
('PLG007','Gita Maharani','P','082665387284','Bangkalan'),
('PLG008','Hendra Wijaya','L','085649286439','Surabaya');

INSERT INTO `user` (username,password,nama,alamat,hp,level) VALUES
('admin',MD5('admin123'),'Admin Coffee','Bangkalan','081654057409',1),
('kasir1',MD5('kasir123'),'Kasir Satu','Surabaya','085393277764',2),
('kasir2',MD5('kasir123'),'Kasir Dua','Bangkalan','088973543268',2),
('owner',MD5('owner123'),'Pemilik Coffee','Gresik','083892737302',3),
('staff1',MD5('staff123'),'Staff Gudang','Surabaya','087639883655',2);

INSERT INTO transaksi (waktu_transaksi,keterangan,total,pelanggan_id) VALUES
('2026-10-01','Pesanan dine in',0,'PLG001'),
('2026-10-02','Pesanan take away',0,'PLG002'),
('2026-10-03','Pesanan pagi',0,'PLG003'),
('2026-10-04','Pesanan dine in',0,'PLG004'),
('2026-10-05','Pesanan take away',0,'PLG005'),
('2026-10-06','Pesanan sore',0,'PLG006'),
('2026-10-07','Pesanan dine in',0,'PLG007'),
('2026-10-08','Pesanan take away',0,'PLG008'),
('2026-10-09','Pesanan rombongan',0,'PLG001'),
('2026-10-10','Pesanan dine in',0,'PLG003');

INSERT INTO transaksi_detail (transaksi_id,barang_id,harga,qty) VALUES
(1,1,18000,1),(1,3,25000,1),
(2,2,20000,2),
(3,4,26000,1),(3,8,24000,1),
(4,5,32000,1),
(5,7,28000,2),
(6,6,29000,1),(6,10,22000,1),
(7,9,30000,1),
(8,1,18000,2),
(9,3,25000,2),(9,5,32000,1),
(10,2,20000,1),(10,8,24000,1);

UPDATE transaksi t SET total = (
  SELECT COALESCE(SUM(td.harga * td.qty),0)
  FROM transaksi_detail td WHERE td.transaksi_id = t.id
);

INSERT INTO pembayaran (waktu_bayar,total,metode,transaksi_id)
SELECT CONCAT(waktu_transaksi,' 12:00:00'), total,
       CASE WHEN id MOD 3 = 0 THEN 'EDC' WHEN id MOD 3 = 1 THEN 'TUNAI' ELSE 'TRANSFER' END,
       id
FROM transaksi;
