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


-- Dumping database structure for bisnis_tamma
CREATE DATABASE IF NOT EXISTS `bisnis_tamma` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bisnis_tamma`;

-- Dumping structure for table bisnis_tamma.d_form_laporan_leader
CREATE TABLE IF NOT EXISTS `d_form_laporan_leader` (
  `fll_id` int(11) NOT NULL AUTO_INCREMENT,
  `fll_pic` char(100) DEFAULT NULL,
  `fll_hari` date DEFAULT NULL,
  `fll_divisi` char(100) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fll_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table bisnis_tamma.d_form_laporan_leader: ~0 rows (approximately)
/*!40000 ALTER TABLE `d_form_laporan_leader` DISABLE KEYS */;
INSERT INTO `d_form_laporan_leader` (`fll_id`, `fll_pic`, `fll_hari`, `fll_divisi`, `CREATED_AT`, `UPDATED_AT`) VALUES
	(3, 'Alpha1', '2018-10-11', 'Keuangan dan Akuntansi', '2018-10-22 13:23:17', NULL),
	(4, 'Zulu23', '2018-10-26', 'General Manager', '2018-10-22 13:23:33', NULL),
	(5, 'Nasikhatul Insaniyah', '2018-10-16', 'HRD dan General Affair', '2018-10-22 13:49:16', NULL),
	(6, 'Mutiara Dicky Via Andini', '2018-10-15', 'HRD dan General Affair', '2018-10-22 14:13:42', NULL),
	(7, 'Ahmad Ghazi', '2018-10-17', 'Gudang dan Pengiriman', '2018-10-22 14:15:51', NULL),
	(8, 'Mutiara Dicky Via Andini', '2018-10-29', 'HRD dan General Affair', '2018-10-22 15:16:54', NULL);
/*!40000 ALTER TABLE `d_form_laporan_leader` ENABLE KEYS */;

-- Dumping structure for table bisnis_tamma.d_form_laporan_leader_dt
CREATE TABLE IF NOT EXISTS `d_form_laporan_leader_dt` (
  `flldt_id` int(11) NOT NULL AUTO_INCREMENT,
  `fll_id` int(11) DEFAULT NULL,
  `flldt_aktifitas` varchar(255) DEFAULT NULL,
  `flldt_keterangan` varchar(255) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`flldt_id`),
  KEY `Index` (`fll_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Dumping data for table bisnis_tamma.d_form_laporan_leader_dt: ~0 rows (approximately)
/*!40000 ALTER TABLE `d_form_laporan_leader_dt` DISABLE KEYS */;
INSERT INTO `d_form_laporan_leader_dt` (`flldt_id`, `fll_id`, `flldt_aktifitas`, `flldt_keterangan`, `CREATED_AT`, `UPDATED_AT`) VALUES
	(7, 3, 'aktif11', 'ket12', '2018-10-22 13:23:17', NULL),
	(8, 3, 'aktif23', 'ket23', '2018-10-22 13:23:17', NULL),
	(9, 3, 'aktif34', 'ke34', '2018-10-22 13:23:17', NULL),
	(10, 3, 'aktif1234455', 'ket5555', '2018-10-22 13:23:17', NULL),
	(11, 4, 'aktif11', 'ket12', '2018-10-22 13:23:33', NULL),
	(12, 4, 'aktif23', 'ket23', '2018-10-22 13:23:33', NULL),
	(13, 4, 'aktif34', 'ke34', '2018-10-22 13:23:33', NULL),
	(14, 4, 'aktif1234455', 'ket5555', '2018-10-22 13:23:33', NULL),
	(15, 5, 'aktif1', 'ket1', '2018-10-22 13:49:16', NULL),
	(16, 5, 'aktif2', 'ket2', '2018-10-22 13:49:16', NULL),
	(17, 5, 'aktif3', 'ket3', '2018-10-22 13:49:16', NULL),
	(18, 6, 'aktif1', 'ket1', '2018-10-22 14:13:42', NULL),
	(19, 6, 'aktif2', 'ket2', '2018-10-22 14:13:42', NULL),
	(20, 7, 'aktif1', 'ket1', '2018-10-22 14:15:51', NULL),
	(21, 7, 'akffi2', 'ket2', '2018-10-22 14:15:51', NULL),
	(22, 7, 'akitf3', 'ket3', '2018-10-22 14:15:51', NULL),
	(23, 7, 'aktfi4', 'ket4', '2018-10-22 14:15:51', NULL),
	(24, 8, 'we', 'we', '2018-10-22 15:16:54', NULL);
/*!40000 ALTER TABLE `d_form_laporan_leader_dt` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
