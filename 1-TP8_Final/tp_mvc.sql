-- 1. Buat database
CREATE DATABASE IF NOT EXISTS tp_mvc;
USE tp_mvc;

-- 2. Tabel DEPARTMENTS
CREATE TABLE IF NOT EXISTS departments (
    department_id INT PRIMARY KEY AUTO_INCREMENT,
    department_name VARCHAR(100) NOT NULL UNIQUE,
    department_code VARCHAR(10) UNIQUE,
    created_at DATE NOT NULL  -- manual, bukan TIMESTAMP otomatis
);

-- Contoh data departments dengan tanggal manual
INSERT INTO departments (department_name, department_code, created_at) VALUES
('Teknik Informatika', 'TI', '2010-08-01'),
('Sistem Informasi', 'SI', '2012-02-15'),
('Ilmu Komputer', 'IK', '2015-06-20');

-- 3. Tabel LECTURERS
CREATE TABLE IF NOT EXISTS lecturers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    nidn VARCHAR(20) UNIQUE NOT NULL,
    phone VARCHAR(15),
    join_date DATE NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(department_id)
);

-- Contoh data lecturers dengan tanggal manual
INSERT INTO lecturers (name, nidn, phone, join_date, department_id) VALUES
('Dr. Budi Santoso', 'NIDN001', '081234567890', '2015-08-01', 1),
('Ibu Ani Lestari', 'NIDN002', '081234567891', '2016-02-15', 2),
('Pak Joko Widodo', 'NIDN003', '081234567892', '2017-06-20', 1);


