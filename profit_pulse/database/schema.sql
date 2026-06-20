-- Profit Pulse MVP Database Schema
-- Run this in phpMyAdmin or: mysql -u root < database/schema.sql

CREATE DATABASE IF NOT EXISTS profit_pulse
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE profit_pulse;

-- Users
CREATE TABLE IF NOT EXISTS users (
    user_id    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50)  NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Products
CREATE TABLE IF NOT EXISTS products (
    product_id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_name        VARCHAR(150)   NOT NULL,
    category            VARCHAR(100)   DEFAULT 'General',
    buying_price        DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    selling_price       DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    quantity            INT            NOT NULL DEFAULT 0,
    low_stock_threshold INT            NOT NULL DEFAULT 10,
    expiry_date         DATE           NULL,
    created_at          TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Customers
CREATE TABLE IF NOT EXISTS customers (
    customer_id   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(150) NOT NULL,
    phone         VARCHAR(20)  NULL,
    address       TEXT         NULL,
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sales
CREATE TABLE IF NOT EXISTS sales (
    sale_id       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id    INT UNSIGNED   NOT NULL,
    customer_id   INT UNSIGNED   NULL,
    quantity      INT            NOT NULL,
    unit_price    DECIMAL(10, 2) NOT NULL,
    total_amount  DECIMAL(10, 2) NOT NULL,
    payment_type  ENUM('cash', 'credit') NOT NULL DEFAULT 'cash',
    sale_date     DATE           NOT NULL,
    created_at    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_sales_product  FOREIGN KEY (product_id)  REFERENCES products(product_id)  ON DELETE RESTRICT,
    CONSTRAINT fk_sales_customer FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Expenses
CREATE TABLE IF NOT EXISTS expenses (
    expense_id   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    expense_type VARCHAR(100)   NOT NULL,
    amount       DECIMAL(10, 2) NOT NULL,
    description  TEXT           NULL,
    expense_date DATE           NOT NULL,
    created_at   TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Debts
CREATE TABLE IF NOT EXISTS debts (
    debt_id      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id  INT UNSIGNED   NOT NULL,
    sale_id      INT UNSIGNED   NULL,
    amount_owed  DECIMAL(10, 2) NOT NULL,
    amount_paid  DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    balance      DECIMAL(10, 2) NOT NULL,
    date_created DATE           NOT NULL,
    created_at   TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_debts_customer FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    CONSTRAINT fk_debts_sale     FOREIGN KEY (sale_id)     REFERENCES sales(sale_id)     ON DELETE SET NULL
) ENGINE=InnoDB;

-- Debt payments history
CREATE TABLE IF NOT EXISTS debt_payments (
    payment_id   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    debt_id      INT UNSIGNED   NOT NULL,
    amount       DECIMAL(10, 2) NOT NULL,
    payment_date DATE           NOT NULL,
    notes        VARCHAR(255)   NULL,
    created_at   TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_payments_debt FOREIGN KEY (debt_id) REFERENCES debts(debt_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Default admin user (password: admin123)
INSERT INTO users (username, password) VALUES
    ('admin', '$2y$10$SfKFgwUWTVvJ1OloWihxbujOYMU3myqPw5sgtQ.rC.Smd5bEJWLP2')
ON DUPLICATE KEY UPDATE username = username;
