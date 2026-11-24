-- DOCUARCH MySQL schema reference.
-- Recommended setup: run `php artisan migrate --seed` instead of importing this file.
CREATE DATABASE IF NOT EXISTS docuarch CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE docuarch;

-- Laravel's default users table is created by the fresh Laravel project.
-- Add these fields to users (the included migration does this):
-- role VARCHAR(255) NOT NULL DEFAULT 'requester'
-- office VARCHAR(255) NULL

CREATE TABLE IF NOT EXISTS documents (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  document_type ENUM('letter','clearance','report') NOT NULL,
  document_number VARCHAR(30) NOT NULL,
  sequence_number INT UNSIGNED NOT NULL,
  year SMALLINT UNSIGNED NOT NULL,
  title VARCHAR(200) NOT NULL,
  sender VARCHAR(150) NOT NULL,
  recipient VARCHAR(150) NULL,
  document_date DATE NOT NULL,
  office VARCHAR(150) NOT NULL,
  description TEXT NULL,
  file_path VARCHAR(255) NULL,
  created_by BIGINT UNSIGNED NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  UNIQUE KEY doc_type_year_sequence_unique (document_type, year, sequence_number),
  UNIQUE KEY doc_type_number_unique (document_type, document_number),
  KEY documents_type_date_index (document_type, document_date),
  CONSTRAINT documents_created_by_foreign FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS archive_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  document_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  action VARCHAR(40) NOT NULL,
  details TEXT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  KEY archive_logs_document_created_index (document_id, created_at),
  CONSTRAINT archive_logs_document_foreign FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE,
  CONSTRAINT archive_logs_user_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
