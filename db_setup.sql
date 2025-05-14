-- Updated Database Setup for Volunteer Crux

CREATE DATABASE IF NOT EXISTS if0_38171036_volunteer_crux;
USE if0_38171036_volunteer_crux;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('volunteer', 'manager', 'admin') NOT NULL,
    skills TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Events Table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    slots INT NOT NULL,
    description TEXT,
    created_by INT NOT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Registrations Table
CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    status ENUM('registered', 'attended') DEFAULT 'registered',
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Certificates Table
CREATE TABLE IF NOT EXISTS certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    certificate_link VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Insert Sample Volunteer Accounts
INSERT INTO users (name, email, password, role, skills) VALUES
('Vardhan Volunteer', '24r21a05eg@mlrit.ac.in', PASSWORD('password123'), 'volunteer', 'Leadership, Communication'),
('Bhargav Volunteer', '24r21a05dw@mlrit.ac.in', PASSWORD('password123'), 'volunteer', 'Teamwork, Problem-Solving');

-- Insert Sample NGO Event Manager Accounts
INSERT INTO users (name, email, password, role) VALUES
('Venu Manager', 'venu.manager@example.com', PASSWORD('managerpass123'), 'manager'),
('Keertan Manager', 'keertan.manager@example.com', PASSWORD('managerpass123'), 'manager'),
('Carol Manager', 'carol.manager@example.com', PASSWORD('manager123'), 'manager'),
('David Manager', 'david.manager@example.com', PASSWORD('manager123'), 'manager');
