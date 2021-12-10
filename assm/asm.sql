-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2021 at 11:42 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `pass`) VALUES
('viet', '111');

-- --------------------------------------------------------

--
-- Table structure for table `anh`
--

CREATE TABLE `anh` (
  `anh1` varchar(50) NOT NULL,
  `anh2` varchar(50) NOT NULL,
  `anh3` varchar(50) NOT NULL,
  `anh4` varchar(50) DEFAULT NULL,
  `anh5` varchar(50) DEFAULT NULL,
  `anh6` varchar(50) DEFAULT NULL,
  `anh7` varchar(50) DEFAULT NULL,
  `MaAnh` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anh`
--

INSERT INTO `anh` (`anh1`, `anh2`, `anh3`, `anh4`, `anh5`, `anh6`, `anh7`, `MaAnh`) VALUES
('item1.png', 'item1--2.png', 'item1--2.png', 'item1--4.png', NULL, NULL, NULL, 1),
('item0-2.png', 'item0--2.png', 'item0--3.png', 'item0--4.png', NULL, NULL, NULL, 2),
('item1.png', 'item1--2.png', 'item1--3.png', 'item1--4.png', NULL, NULL, NULL, 3),
('item2-1.jpg', 'item2--2.png', 'item2--3.png', 'item2--4.png', NULL, NULL, NULL, 4),
('item3.jpg', 'item3--1.png', 'item3--2.png', 'item3--3.png', NULL, NULL, NULL, 5),
('item4-1.png', 'item4--2.png', 'item4--3.png', 'item4--4.png', NULL, NULL, NULL, 6),
('item5-2.png', 'item5--2.png', 'item5--3.png', 'item5--4.png', NULL, NULL, NULL, 7),
('4e83f3f9249dd3c38a8c.jpg', '9e9cc9c0eca71bf942b6.jpg', '9e9cc9c0eca71bf942b6.jpg', '651297bb40dfb781eece.jpg', NULL, NULL, NULL, 8),
('4e83f3f9249dd3c38a8c.jpg', '105373707_168821267987976_515794517038581527_n.jpg', '9e9cc9c0eca71bf942b6.jpg', '651297bb40dfb781eece.jpg', NULL, NULL, NULL, 11),
('4e83f3f9249dd3c38a8c.jpg', '4e83f3f9249dd3c38a8c.jpg', '9e9cc9c0eca71bf942b6.jpg', '651297bb40dfb781eece.jpg', NULL, NULL, NULL, 14),
('4e83f3f9249dd3c38a8c.jpg', '651297bb40dfb781eece.jpg', '105373707_168821267987976_515794517038581527_n.jpg', '291713910d3966b3d715cfe89454b04e-27201662193264337', NULL, NULL, NULL, 15),
('', '4e83f3f9249dd3c38a8c.jpg', '4e83f3f9249dd3c38a8c.jpg', '9e9cc9c0eca71bf942b6.jpg', '291713910d3966b3d715cfe89454b04e-27201662193264337', NULL, NULL, 16),
('9e9cc9c0eca71bf942b6.jpg', '291713910d3966b3d715cfe89454b04e-27201662193264337', '651297bb40dfb781eece.jpg', '105373707_168821267987976_515794517038581527_n.jpg', NULL, NULL, NULL, 17),
('4e83f3f9249dd3c38a8c.jpg', '9e9cc9c0eca71bf942b6.jpg', '105373707_168821267987976_515794517038581527_n.jpg', '291713910d3966b3d715cfe89454b04e-27201662193264337', NULL, NULL, NULL, 18),
('4e83f3f9249dd3c38a8c.jpg', '291713910d3966b3d715cfe89454b04e-27201662193264337', '9e9cc9c0eca71bf942b6.jpg', '651297bb40dfb781eece.jpg', NULL, NULL, NULL, 19),
('4e83f3f9249dd3c38a8c.jpg', '4e83f3f9249dd3c38a8c.jpg', '9e9cc9c0eca71bf942b6.jpg', '651297bb40dfb781eece.jpg', NULL, NULL, NULL, 20),
('651297bb40dfb781eece.jpg', '9e9cc9c0eca71bf942b6.jpg', '105373707_168821267987976_515794517038581527_n.jpg', '291713910d3966b3d715cfe89454b04e-27201662193264337', NULL, NULL, NULL, 21),
('651297bb40dfb781eece.jpg', '9e9cc9c0eca71bf942b6.jpg', '105373707_168821267987976_515794517038581527_n.jpg', '291713910d3966b3d715cfe89454b04e-27201662193264337', NULL, NULL, NULL, 22),
('4e83f3f9249dd3c38a8c.jpg', '9e9cc9c0eca71bf942b6.jpg', '9e9cc9c0eca71bf942b6.jpg', '651297bb40dfb781eece.jpg', NULL, NULL, NULL, 23),
('4e83f3f9249dd3c38a8c.jpg', '4e83f3f9249dd3c38a8c.jpg', '9e9cc9c0eca71bf942b6.jpg', '651297bb40dfb781eece.jpg', '105373707_168821267987976_515794517038581527_n.jpg', NULL, NULL, 24),
('4e83f3f9249dd3c38a8c.jpg', '4e83f3f9249dd3c38a8c.jpg', '9e9cc9c0eca71bf942b6.jpg', '651297bb40dfb781eece.jpg', NULL, NULL, NULL, 25),
('4e83f3f9249dd3c38a8c.jpg', '4e83f3f9249dd3c38a8c.jpg', '9e9cc9c0eca71bf942b6.jpg', '651297bb40dfb781eece.jpg', NULL, NULL, NULL, 26);

-- --------------------------------------------------------

--
-- Table structure for table `cthd`
--

CREATE TABLE `cthd` (
  `SoLuong` int(11) NOT NULL,
  `STT` int(11) NOT NULL,
  `GiaBan` int(11) NOT NULL,
  `SOHD` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `MaGH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `SOHD` int(11) NOT NULL,
  `NgayXuatHD` date NOT NULL,
  `TriGia` int(11) NOT NULL,
  `ThanhTien` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `MaTT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`SOHD`, `NgayXuatHD`, `TriGia`, `ThanhTien`, `MaKH`, `MaTT`) VALUES
(1, '2021-07-01', 0, 2500000, 2, 1),
(2, '2021-01-09', 0, 3500000, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `DiaChi` char(50) NOT NULL,
  `SoDT` char(11) NOT NULL,
  `Email` char(50) NOT NULL,
  `username` char(50) NOT NULL,
  `password` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `HoTen`, `DiaChi`, `SoDT`, `Email`, `username`, `password`) VALUES
(1, 'Phạm Công Việt', 'hồ chí Minh', '0387991508', 'viet@gmail.com', 'viet', '123'),
(2, 'nguyên văn an', 'long an', '03333333', 'an@gmail.com', 'an', '123'),
(6, 'âs', 'âs', '0123456789', 'asdase@gmail.com', '1234', '1234'),
(7, '123', '123', '1223', 'dddd@gmail.com', '1234333', '123');

-- --------------------------------------------------------

--
-- Table structure for table `loaisp`
--

CREATE TABLE `loaisp` (
  `MaLoai` int(11) NOT NULL,
  `TenLoai` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loaisp`
--

INSERT INTO `loaisp` (`MaLoai`, `TenLoai`) VALUES
(1, 'Walking'),
(2, 'Lifestyle'),
(3, 'Running');

-- --------------------------------------------------------

--
-- Table structure for table `nhasx`
--

CREATE TABLE `nhasx` (
  `MaNSX` int(11) NOT NULL,
  `TenNSX` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhasx`
--

INSERT INTO `nhasx` (`MaNSX`, `TenNSX`) VALUES
(1, 'adidas'),
(2, 'nike'),
(3, 'converse'),
(4, 'vans'),
(5, 'puma');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `TenSP` varchar(250) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `GiaCu` float NOT NULL,
  `GiaMoi` float NOT NULL,
  `gioitinh` varchar(200) NOT NULL,
  `MaLoai` int(11) NOT NULL,
  `MaNSX` int(11) NOT NULL,
  `MaAnh` int(11) NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`TenSP`, `MaSP`, `GiaCu`, `GiaMoi`, `gioitinh`, `MaLoai`, `MaNSX`, `MaAnh`, `views`) VALUES
('Giày Thể Thao Adidas Ultraboost 21', 24, 1500000, 1405000, 'men', 2, 1, 1, 226),
('Giày Thể Thao Adidas Vl Court 2.0', 25, 1500000, 1405000, 'women', 2, 2, 2, 2222),
('Giày Thể Thao Skechers DLITES 4.0', 26, 1500000, 1405000, 'women', 2, 1, 3, 22227),
('Giày Thể Thao Skechers Ultra Flex 2.0 - Wild Yoyage', 27, 1500000, 1405000, 'kid', 2, 3, 4, 222233),
('Giày Thể Thao Adidas Ultraboost 21', 28, 1500000, 1405000, 'kid', 2, 1, 5, 222240),
('Giày Thể Thao Adidas Vl Court 2.0', 29, 1500000, 1405000, 'men', 2, 2, 3, 2247),
('Giày Thể Thao Skechers DLITES 4.0', 30, 1500000, 1405000, 'kid', 2, 1, 2, 24),
('Giày Thể Thao Adidas Vl Court 2.0', 31, 1500000, 1405000, 'women', 2, 2, 2, 235),
('Giày Thể Thao Skechers DLITES 4.0', 32, 1500000, 1405000, 'kid', 2, 1, 3, 2240),
('Giày Thể Thao Skechers Ultra Flex 2.0 - Wild Yoyage', 33, 1500000, 1405000, 'men', 2, 4, 4, 2229),
('Giày Thể Thao Adidas Ultraboost 21', 34, 1500000, 1405000, 'men', 2, 1, 5, 2224);

-- --------------------------------------------------------

--
-- Table structure for table `trangthaihd`
--

CREATE TABLE `trangthaihd` (
  `Trangthai` int(11) NOT NULL,
  `MaTT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trangthaihd`
--

INSERT INTO `trangthaihd` (`Trangthai`, `MaTT`) VALUES
(0, 1),
(0, 2),
(0, 3),
(0, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anh`
--
ALTER TABLE `anh`
  ADD PRIMARY KEY (`MaAnh`);

--
-- Indexes for table `cthd`
--
ALTER TABLE `cthd`
  ADD PRIMARY KEY (`STT`),
  ADD KEY `SOHD` (`SOHD`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGH`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`SOHD`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaTT` (`MaTT`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`);

--
-- Indexes for table `loaisp`
--
ALTER TABLE `loaisp`
  ADD PRIMARY KEY (`MaLoai`);

--
-- Indexes for table `nhasx`
--
ALTER TABLE `nhasx`
  ADD PRIMARY KEY (`MaNSX`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaLoai` (`MaLoai`),
  ADD KEY `MaNSX` (`MaNSX`),
  ADD KEY `MaAnh` (`MaAnh`);

--
-- Indexes for table `trangthaihd`
--
ALTER TABLE `trangthaihd`
  ADD PRIMARY KEY (`MaTT`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anh`
--
ALTER TABLE `anh`
  MODIFY `MaAnh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cthd`
--
ALTER TABLE `cthd`
  MODIFY `STT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `SOHD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loaisp`
--
ALTER TABLE `loaisp`
  MODIFY `MaLoai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nhasx`
--
ALTER TABLE `nhasx`
  MODIFY `MaNSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `trangthaihd`
--
ALTER TABLE `trangthaihd`
  MODIFY `MaTT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cthd`
--
ALTER TABLE `cthd`
  ADD CONSTRAINT `cthd_ibfk_1` FOREIGN KEY (`SOHD`) REFERENCES `hoadon` (`SOHD`),
  ADD CONSTRAINT `cthd_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Constraints for table `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`),
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`MaTT`) REFERENCES `trangthaihd` (`MaTT`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaLoai`) REFERENCES `loaisp` (`MaLoai`),
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`MaNSX`) REFERENCES `nhasx` (`MaNSX`),
  ADD CONSTRAINT `sanpham_ibfk_3` FOREIGN KEY (`MaAnh`) REFERENCES `anh` (`MaAnh`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
