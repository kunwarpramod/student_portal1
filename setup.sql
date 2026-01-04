CREATE DATABASE IF NOT EXISTS herald_db;
USE herald_db;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);

-- Optional: Insert a test user (hash generated via PHP's password_hash)
-- Replace the hash with a real one after using register.php once.
INSERT INTO students (student_id, full_name, password_hash) VALUES
('np0001', 'Test User', '$2y$10$replace_this_with_real_hash');
