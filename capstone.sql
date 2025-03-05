CREATE DATABASE capstone;

USE capstone;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    middlename VARCHAR(50),
    lastname VARCHAR(50) NOT NULL,
    birthdate DATE NOT NULL,
    age INT NOT NULL CHECK (age >= 18), -- Assuming registration is for adults
    housenumber VARCHAR(10) NOT NULL,
    street VARCHAR(100) NOT NULL,
    barangay ENUM('Kalawaan', 'Pantok', 'Calumpang', 'Libis', 'Pag-asa') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    cellphone VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE users
ADD COLUMN theme ENUM('light', 'dark') DEFAULT 'light';

CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    certificate_type ENUM('Barangay', 'Residency', 'Indigency', 'Business', 'Travel') NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    birthdate DATE NOT NULL,
    civil_status VARCHAR(50),
    purpose VARCHAR(100),
    duration VARCHAR(50),
    family_members INT,
    income_source VARCHAR(100),
    business_name VARCHAR(100),
    business_address VARCHAR(255),
    business_type VARCHAR(50),
    registration_number VARCHAR(50),
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


ALTER TABLE certificates
ADD COLUMN status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending';

CREATE TABLE business_certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    business_name VARCHAR(255) NOT NULL,
    business_address VARCHAR(255) NOT NULL,
    business_type VARCHAR(100) NOT NULL,
    registration_number VARCHAR(100) NOT NULL,
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE business_certificates ADD COLUMN requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

