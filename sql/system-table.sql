/* Users Table */

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    
    tenant_id INT UNSIGNED NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    is_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(255) DEFAULT NULL,
    verification_expires_at DATETIME DEFAULT NULL,

    password_expires_at DATETIME DEFAULT NULL,

    remember_token VARCHAR(255) DEFAULT NULL,
    
    failed_login_attempts INT UNSIGNED DEFAULT 0,
    locked_until DATETIME DEFAULT NULL,

    two_factor_enabled TINYINT(1) DEFAULT 0,
    otp_code VARCHAR(10) DEFAULT NULL,
    otp_expires_at DATETIME DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_tenant (tenant_id),
    INDEX idx_verification_token (verification_token),
    INDEX idx_remember_token (remember_token)
);

/* ----------------------------------------------------------------------------------------------------------------------------- */