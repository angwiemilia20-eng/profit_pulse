-- Profit Pulse — incremental migration (safe for existing databases)
-- Run: Get-Content database/migrate.sql | c:\xampp\mysql\bin\mysql.exe -u root

USE profit_pulse;

-- Users: align with username-based auth
ALTER TABLE users ADD COLUMN IF NOT EXISTS username VARCHAR(50) NULL AFTER user_id;
UPDATE users SET username = SUBSTRING_INDEX(email, '@', 1) WHERE username IS NULL OR username = '';
UPDATE users SET username = email WHERE username IS NULL OR username = '';
UPDATE users SET username = CONCAT('user', user_id) WHERE username IS NULL OR username = '';

-- Products: add missing MVP columns
ALTER TABLE products ADD COLUMN IF NOT EXISTS category VARCHAR(100) DEFAULT 'General' AFTER product_name;
ALTER TABLE products ADD COLUMN IF NOT EXISTS low_stock_threshold INT NOT NULL DEFAULT 10 AFTER quantity;
ALTER TABLE products ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Sales: align column names and add credit-sale support
ALTER TABLE sales ADD COLUMN IF NOT EXISTS quantity INT NULL AFTER product_id;
UPDATE sales SET quantity = quantity_sold WHERE quantity IS NULL AND quantity_sold IS NOT NULL;

ALTER TABLE sales ADD COLUMN IF NOT EXISTS unit_price DECIMAL(10, 2) NULL AFTER quantity;
UPDATE sales SET unit_price = selling_price WHERE unit_price IS NULL AND selling_price IS NOT NULL;

ALTER TABLE sales ADD COLUMN IF NOT EXISTS customer_id INT UNSIGNED NULL AFTER product_id;
ALTER TABLE sales ADD COLUMN IF NOT EXISTS payment_type ENUM('cash', 'credit') NOT NULL DEFAULT 'cash' AFTER total_amount;

-- Debts
CREATE TABLE IF NOT EXISTS debts (
    debt_id      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id  INT UNSIGNED   NOT NULL,
    sale_id      INT            NULL,
    amount_owed  DECIMAL(10, 2) NOT NULL,
    amount_paid  DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    balance      DECIMAL(10, 2) NOT NULL,
    date_created DATE           NOT NULL,
    created_at   TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_debts_customer (customer_id),
    INDEX idx_debts_sale (sale_id)
) ENGINE=InnoDB;

-- Debt payments
CREATE TABLE IF NOT EXISTS debt_payments (
    payment_id   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    debt_id      INT UNSIGNED   NOT NULL,
    amount       DECIMAL(10, 2) NOT NULL,
    payment_date DATE           NOT NULL,
    notes        VARCHAR(255)   NULL,
    created_at   TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_payments_debt (debt_id)
) ENGINE=InnoDB;

-- Default admin (username: admin, password: admin123)
INSERT INTO users (username, full_name, email, password)
SELECT 'admin', 'Administrator', 'admin@profitpulse.local',
       '$2y$10$SfKFgwUWTVvJ1OloWihxbujOYMU3myqPw5sgtQ.rC.Smd5bEJWLP2'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'admin' OR email = 'admin@profitpulse.local');

UPDATE users SET username = 'admin', password = '$2y$10$SfKFgwUWTVvJ1OloWihxbujOYMU3myqPw5sgtQ.rC.Smd5bEJWLP2'
WHERE email = 'admin@profitpulse.local' OR username = 'admin';
