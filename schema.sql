CREATE DATABASE IF NOT EXISTS findit CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE findit;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE item_reports (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  report_type ENUM('lost', 'found') NOT NULL,
  item_name VARCHAR(120) NOT NULL,
  category VARCHAR(60) NOT NULL,
  colour VARCHAR(60) NULL,
  description TEXT NOT NULL,
  location VARCHAR(120) NOT NULL,
  incident_date DATE NOT NULL,
  image_path VARCHAR(255) NULL,
  status ENUM('active', 'under_review', 'resolved', 'withdrawn') NOT NULL DEFAULT 'active',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_reports_user FOREIGN KEY (user_id) REFERENCES users(id),
  INDEX idx_reports_browse (status, report_type, category, location, incident_date)
) ENGINE=InnoDB;

CREATE TABLE match_suggestions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  lost_report_id INT UNSIGNED NOT NULL,
  found_report_id INT UNSIGNED NOT NULL,
  score TINYINT UNSIGNED NOT NULL,
  match_reasons TEXT NOT NULL,
  status ENUM('suggested', 'dismissed', 'accepted', 'closed') NOT NULL DEFAULT 'suggested',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_match_pair (lost_report_id, found_report_id),
  CONSTRAINT fk_match_lost FOREIGN KEY (lost_report_id) REFERENCES item_reports(id),
  CONSTRAINT fk_match_found FOREIGN KEY (found_report_id) REFERENCES item_reports(id)
) ENGINE=InnoDB;

CREATE TABLE recovery_requests (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  match_id INT UNSIGNED NOT NULL,
  claimant_id INT UNSIGNED NOT NULL,
  private_details TEXT NOT NULL,
  status ENUM('pending', 'approved', 'rejected', 'completed') NOT NULL DEFAULT 'pending',
  reviewed_by INT UNSIGNED NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_claim_match FOREIGN KEY (match_id) REFERENCES match_suggestions(id),
  CONSTRAINT fk_claimant FOREIGN KEY (claimant_id) REFERENCES users(id),
  CONSTRAINT fk_claim_reviewer FOREIGN KEY (reviewed_by) REFERENCES users(id),
  UNIQUE KEY uq_claimant_match (match_id, claimant_id)
) ENGINE=InnoDB;
