CREATE DATABASE IF NOT EXISTS lead_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE lead_portal;

CREATE TABLE IF NOT EXISTS employee_data (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
designation VARCHAR(100),
phone VARCHAR(50),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tbl_users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
employee_id INT DEFAULT NULL,
access_level TINYINT NOT NULL DEFAULT 4,
is_blocked TINYINT(1) DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (employee_id) REFERENCES employee_data(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS file_data (
id INT AUTO_INCREMENT PRIMARY KEY,
contact_number VARCHAR(50) NOT NULL UNIQUE,
name VARCHAR(255),
client VARCHAR(255),
source VARCHAR(100),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS lead_data (
id INT AUTO_INCREMENT PRIMARY KEY,
contact_number VARCHAR(50) NOT NULL,
name VARCHAR(255),
client VARCHAR(255),
loan_officer VARCHAR(255),
comments TEXT,
submitted_by INT,
sale_date DATE DEFAULT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
UNIQUE KEY unique_contact_created (contact_number, DATE(created_at))
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS lead_disposition (
id INT AUTO_INCREMENT PRIMARY KEY,
lead_id INT NOT NULL,
disposition VARCHAR(255),
csr_id INT,
notes TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (lead_id) REFERENCES lead_data(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO employee_data (name, email, designation, phone) VALUES ('Admin User', 'admin@example.com', 'Administrator', '');
INSERT INTO tbl_users (username, password, employee_id, access_level, is_blocked)
VALUES ('admin', SHA2('admin123',256), 1, 1, 0);