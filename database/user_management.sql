DROP TABLE IF EXISTS `users`;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(8) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    role ENUM('admin', 'member') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    remember_token VARCHAR(255) NULL
);

INSERT INTO users (username, password, email, description, role, remember_token)
VALUES
    ('user01', '$2y$10$abcdefg1234567890hijklmn', 'user01@example.com', 'Description 1', 'admin', NULL),
    ('usr123', '$2y$10$abcdefg1234567890hijklmn', 'usr123@example.com', 'Description 2', 'member', NULL),
    ('john', '$2y$10$abcdefg1234567890hijklmn', 'john@example.com', 'Description 3', 'admin', NULL),
    ('alice', '$2y$10$abcdefg1234567890hijklmn', 'alice@example.com', 'Description 4', 'member', NULL),
    ('markus', '$2y$10$abcdefg1234567890hijklmn', 'markus@example.com', 'Description 5', 'admin', NULL),
    ('susan', '$2y$10$abcdefg1234567890hijklmn', 'susan@example.com', 'Description 6', 'member', NULL),
    ('peter99', '$2y$10$abcdefg1234567890hijklmn', 'peter99@example.com', 'Description 7', 'admin', NULL),
    ('maria', '$2y$10$abcdefg1234567890hijklmn', 'maria@example.com', 'Description 8', 'member', NULL),
    ('tommy', '$2y$10$abcdefg1234567890hijklmn', 'tommy@example.com', 'Description 9', 'admin', NULL),
    ('emma07', '$2y$10$abcdefg1234567890hijklmn', 'emma07@example.com', 'Description 10', 'member', NULL),
    ('leo', '$2y$10$abcdefg1234567890hijklmn', 'leo@example.com', 'Description 11', 'admin', NULL),
    ('sarah', '$2y$10$abcdefg1234567890hijklmn', 'sarah@example.com', 'Description 12', 'member', NULL),
    ('kevin88', '$2y$10$abcdefg1234567890hijklmn', 'kevin88@example.com', 'Description 13', 'admin', NULL),
    ('julia5', '$2y$10$abcdefg1234567890hijklmn', 'julia5@example.com', 'Description 14', 'member', NULL),
    ('daniel', '$2y$10$abcdefg1234567890hijklmn', 'daniel@example.com', 'Description 15', 'admin', NULL),
    ('clara', '$2y$10$abcdefg1234567890hijklmn', 'clara@example.com', 'Description 16', 'member', NULL),
    ('mike', '$2y$10$abcdefg1234567890hijklmn', 'mike@example.com', 'Description 17', 'admin', NULL),
    ('nina77', '$2y$10$abcdefg1234567890hijklmn', 'nina77@example.com', 'Description 18', 'member', NULL),
    ('robert', '$2y$10$abcdefg1234567890hijklmn', 'robert@example.com', 'Description 19', 'admin', NULL),
    ('zoe', '$2y$10$abcdefg1234567890hijklmn', 'zoe@example.com', 'Description 20', 'member', NULL);
