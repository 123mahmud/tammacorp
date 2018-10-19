-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.31-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table bisnis_tamma.d_form_keterangan_kerja
CREATE TABLE IF NOT EXISTS `d_form_keterangan_kerja` (
  `fkj_id` int(11) NOT NULL AUTO_INCREMENT,
  `fkjdt_id` int(11) DEFAULT NULL,
  `fkj_kode` char(25) DEFAULT NULL,
  `fkj_tanggal_awal` date DEFAULT NULL,
  `fkj_tanggal_akhir` date DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fkj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table bisnis_tamma.d_form_keterangan_kerja: ~0 rows (approximately)
/*!40000 ALTER TABLE `d_form_keterangan_kerja` DISABLE KEYS */;
/*!40000 ALTER TABLE `d_form_keterangan_kerja` ENABLE KEYS */;

-- Dumping structure for table bisnis_tamma.d_form_keterangan_kerja_dt
CREATE TABLE IF NOT EXISTS `d_form_keterangan_kerja_dt` (
  `fkjdt_id` int(11) NOT NULL AUTO_INCREMENT,
  `fkjdt_nama1` char(100) DEFAULT NULL,
  `fkjdt_jabatan1` char(100) DEFAULT NULL,
  `fkjdt_alamat1` char(100) DEFAULT NULL,
  `fkjdt_nama2` char(100) DEFAULT NULL,
  `fkjdt_jk2` char(20) DEFAULT NULL,
  `fkjdt_ttl2` char(50) DEFAULT NULL,
  `fkjdt_alamat2` char(100) DEFAULT NULL,
  `fkjdt_posisi2` char(100) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fkjdt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table bisnis_tamma.d_form_keterangan_kerja_dt: ~0 rows (approximately)
/*!40000 ALTER TABLE `d_form_keterangan_kerja_dt` DISABLE KEYS */;
/*!40000 ALTER TABLE `d_form_keterangan_kerja_dt` ENABLE KEYS */;

-- Dumping structure for table bisnis_tamma.d_form_overhandle
CREATE TABLE IF NOT EXISTS `d_form_overhandle` (
  `foh_id` int(11) NOT NULL AUTO_INCREMENT,
  `fohdt_id` int(11) DEFAULT NULL,
  `foh_surat` char(25) DEFAULT NULL,
  `foh_tugas` char(100) DEFAULT NULL,
  `foh_awal_tanggal` date DEFAULT NULL,
  `foh_akhir_tanggal` date DEFAULT NULL,
  `foh_dibuat_di` char(50) DEFAULT NULL,
  `foh_tanggal` char(50) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`foh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table bisnis_tamma.d_form_overhandle: ~0 rows (approximately)
/*!40000 ALTER TABLE `d_form_overhandle` DISABLE KEYS */;
/*!40000 ALTER TABLE `d_form_overhandle` ENABLE KEYS */;

-- Dumping structure for table bisnis_tamma.d_form_overhandle_dt
CREATE TABLE IF NOT EXISTS `d_form_overhandle_dt` (
  `fohdt_id` int(11) NOT NULL AUTO_INCREMENT,
  `fohdt_nama1` char(50) DEFAULT NULL,
  `fohdt_ktp1` char(50) DEFAULT NULL,
  `fohdt_alamat1` char(50) DEFAULT NULL,
  `fohdt_posisi1` char(50) DEFAULT NULL,
  `fohdt_nik1` char(50) DEFAULT NULL,
  `fohdt_nama2` char(50) DEFAULT NULL,
  `fohdt_ktp2` char(50) DEFAULT NULL,
  `fohdt_alamat2` char(50) DEFAULT NULL,
  `fohdt_posisi2` char(50) DEFAULT NULL,
  `fohdt_nik2` char(50) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fohdt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table bisnis_tamma.d_form_overhandle_dt: ~0 rows (approximately)
/*!40000 ALTER TABLE `d_form_overhandle_dt` DISABLE KEYS */;
/*!40000 ALTER TABLE `d_form_overhandle_dt` ENABLE KEYS */;

-- Dumping structure for table bisnis_tamma.d_form_permintaan_karyawan_baru
CREATE TABLE IF NOT EXISTS `d_form_permintaan_karyawan_baru` (
  `pkb_id` int(11) NOT NULL AUTO_INCREMENT,
  `pkb_departement` char(50) DEFAULT NULL,
  `pkb_tgl_pengujian` date DEFAULT NULL,
  `pkb_tgl_masuk` date DEFAULT NULL,
  `pkb_posisi` char(100) DEFAULT NULL,
  `pkb_jumlah_butuh` int(11) DEFAULT NULL,
  `pkb_jumlah_karyawan` int(11) DEFAULT NULL,
  `pkb_penambahan` int(11) DEFAULT NULL,
  `pkb_alasan` varchar(100) DEFAULT NULL,
  `pkb_usia` int(11) DEFAULT NULL,
  `pkb_jk` enum('l','p') DEFAULT NULL,
  `pkb_pendidikan` char(5) DEFAULT NULL,
  `pkb_pengalaman` varchar(255) DEFAULT NULL,
  `pkb_keahlian` varchar(255) DEFAULT NULL,
  `pkb_gaji` decimal(10,2) DEFAULT NULL,
  `pkb_keterangan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pkb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table bisnis_tamma.d_form_permintaan_karyawan_baru: ~2 rows (approximately)
/*!40000 ALTER TABLE `d_form_permintaan_karyawan_baru` DISABLE KEYS */;
INSERT INTO `d_form_permintaan_karyawan_baru` (`pkb_id`, `pkb_departement`, `pkb_tgl_pengujian`, `pkb_tgl_masuk`, `pkb_posisi`, `pkb_jumlah_butuh`, `pkb_jumlah_karyawan`, `pkb_penambahan`, `pkb_alasan`, `pkb_usia`, `pkb_jk`, `pkb_pendidikan`, `pkb_pengalaman`, `pkb_keahlian`, `pkb_gaji`, `pkb_keterangan`) VALUES
	(1, 'EA', '2018-10-09', '2018-10-24', 'Staf HRD Rekrutmen dan Pelatihan', 2, 15, 2, '-', 25, 'l', 'SMA', '-', '-', 1000000.00, '-'),
	(2, 'Rockstra', '2018-10-09', '2018-10-24', 'Staf Personalia dan Perfomance Managerial', 15, 5, 3, '-', 25, 'p', 'S1', '-', '-', 150000.00, '-');
/*!40000 ALTER TABLE `d_form_permintaan_karyawan_baru` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
