-- ============================================================
-- Certificate System - Database Schema
-- Import this file in phpMyAdmin (XAMPP) to set everything up.
-- ============================================================

CREATE DATABASE IF NOT EXISTS cert_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cert_system;

-- ---------------------------------------------------
-- Users (login accounts)
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(100) NOT NULL,
  role ENUM('admin','staff') NOT NULL DEFAULT 'staff',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, name, role) VALUES
('admin', 'admin123', 'Administrator', 'admin'),
('staff', 'staff123', 'Staff Member', 'staff');

-- ---------------------------------------------------
-- Students (shared by Transfer Certificate + Bonafide Certificate)
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS students (
  id VARCHAR(50) PRIMARY KEY,
  sl_no VARCHAR(20),
  admission_no VARCHAR(50),
  umis_id VARCHAR(50),
  reg_no VARCHAR(50),
  name VARCHAR(150) NOT NULL,
  father_name VARCHAR(150),
  nationality VARCHAR(100),
  religion VARCHAR(100),
  community_caste VARCHAR(100),
  sex VARCHAR(10),
  dob DATE NULL,
  date_of_admission DATE NULL,
  medium VARCHAR(100),
  class_at_leaving VARCHAR(100),
  promotion_status VARCHAR(100),
  date_of_leaving DATE NULL,
  reason_for_leaving TEXT,
  date_of_tc_application DATE NULL,
  conduct_character VARCHAR(255),
  date_of_issue DATE NULL,
  current_year VARCHAR(20),
  branch VARCHAR(255),
  academic_year_from VARCHAR(20),
  academic_year_to VARCHAR(20),
  admission_year VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ---------------------------------------------------
-- Reports (log of every TC / Bonafide certificate issued)
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS reports (
  id VARCHAR(50) PRIMARY KEY,
  type ENUM('TC','BONAFIDE') NOT NULL,
  student_id VARCHAR(50),
  student_name VARCHAR(150),
  admission_no VARCHAR(50),
  issued_by VARCHAR(50),
  issued_by_name VARCHAR(100),
  date_of_issue DATE NULL,
  timestamp DATETIME,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE SET NULL
);

-- ---------------------------------------------------
-- Settings (single row — institution details, principal, backup email)
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS settings (
  id INT PRIMARY KEY DEFAULT 1,
  college_name VARCHAR(255),
  address VARCHAR(255),
  approval TEXT,
  phone VARCHAR(50),
  email VARCHAR(100),
  principal_name VARCHAR(150),
  principal_title VARCHAR(100),
  logo_data_url LONGTEXT,
  backup_email VARCHAR(150)
);

INSERT INTO settings (id, college_name, address, phone, email, principal_name, principal_title) VALUES
(1, 'SBM POLYTECHNIC COLLEGE', 'SBM NAGAR, TRICHY ROAD, THAMARAIPADI (PO), DINDIGUL - 5',
 '0451-2051943', '538sbm@gmail.com', 'Mr. JEEVANANTHAM V.,M.E', 'Principal');
