CREATE TABLE images (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,         -- e.g. 'user', 'post', 'comment'
    type_id INT UNSIGNED NOT NULL,     -- ID of the user, post, etc.
    filename VARCHAR(255) NOT NULL,
    filepath VARCHAR(255) NOT NULL,
    mimetype VARCHAR(100) NOT NULL,
    size INT UNSIGNED NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(500) DEFAULT NULL,
    INDEX(type, type_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;