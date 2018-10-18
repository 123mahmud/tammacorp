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

-- Dumping structure for table bisnis_tamma.d_form_overhandle
CREATE TABLE IF NOT EXISTS `d_form_overhandle` (
  `foh_id` int(11) DEFAULT NULL,
  `foh_surat` char(15) DEFAULT NULL,
  `foh_karyawan1` char(100) DEFAULT NULL,
  `foh_tugas` char(100) DEFAULT NULL,
  `foh_karyawan2` char(100) DEFAULT NULL,
  `foh_awal_tanggal` date DEFAULT NULL,
  `foh_akhir_tanggal` date DEFAULT NULL,
  `foh_dibuat_di` char(50) DEFAULT NULL,
  `foh_tanggal` char(50) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table bisnis_tamma.d_form_overhandle: ~1 rows (approximately)
/*!40000 ALTER TABLE `d_form_overhandle` DISABLE KEYS */;
INSERT INTO `d_form_overhandle` (`foh_id`, `foh_surat`, `foh_karyawan1`, `foh_tugas`, `foh_karyawan2`, `foh_awal_tanggal`, `foh_akhir_tanggal`, `foh_dibuat_di`, `foh_tanggal`, `CREATED_AT`, `UPDATED_AT`) VALUES
	(1, '003/STT/HRD/X/2', '2', 'Loader', '7', '2018-10-01', '2018-10-26', 'sby', '2018-10-18', '2018-10-18 14:14:56', NULL),
	(2, '003/STT/HRD/X/2', '5', 'Gunner', '3', '2018-10-01', '2018-10-26', 'sby', '2018-10-18', '2018-10-18 14:16:22', NULL);
/*!40000 ALTER TABLE `d_form_overhandle` ENABLE KEYS */;

-- Dumping structure for table bisnis_tamma.d_form_overhandle_dt
CREATE TABLE IF NOT EXISTS `d_form_overhandle_dt` (
  `fohdt_id` int(11) DEFAULT NULL,
  `fohdt_karyawan1` int(11) DEFAULT NULL,
  `fohdt_nama1` char(50) DEFAULT NULL,
  `fohdt_ktp1` char(50) DEFAULT NULL,
  `fohdt_alamat1` char(50) DEFAULT NULL,
  `fohdt_posisi1` char(50) DEFAULT NULL,
  `fohdt_nik1` char(50) DEFAULT NULL,
  `fohdt_karyawan2` char(50) DEFAULT NULL,
  `fohdt_nama2` char(50) DEFAULT NULL,
  `fohdt_ktp2` char(50) DEFAULT NULL,
  `fohdt_alamat2` char(50) DEFAULT NULL,
  `fohdt_posisi2` char(50) DEFAULT NULL,
  `fohdt_nik2` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table bisnis_tamma.d_form_overhandle_dt: ~0 rows (approximately)
/*!40000 ALTER TABLE `d_form_overhandle_dt` DISABLE KEYS */;
INSERT INTO `d_form_overhandle_dt` (`fohdt_id`, `fohdt_karyawan1`, `fohdt_nama1`, `fohdt_ktp1`, `fohdt_alamat1`, `fohdt_posisi1`, `fohdt_nik1`, `fohdt_karyawan2`, `fohdt_nama2`, `fohdt_ktp2`, `fohdt_alamat2`, `fohdt_posisi2`, `fohdt_nik2`) VALUES
	(1, 2, 'Nasikhatul Insaniyah', 'KTP (3578274608930005)', '-', 'Kepala HRD', '170101005', '7', 'Amaliyah Nur Hidayah', NULL, '-', 'Keuangan dan Akuntansi', '140201003'),
	(2, 5, 'Arief Rakhman Hidayat', 'KTP (3578022010850006)', '-', 'Staf General Affair', '180102005', '3', 'Mutiara Dicky Via Andini', 'KTP (3578106005940001)', '-', 'Staf Personalia dan Perfomance Managerial', '180102004');
/*!40000 ALTER TABLE `d_form_overhandle_dt` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
