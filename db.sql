-- -- 1 Create Database
CREATE DATABASE Smart_Wallet;
-- GO

-- -- 2 Select Database
USE smart_wallet;
-- GO

-- TRUNCATE TABLE income;
-- TRUNCATE TABLE expense;


CREATE TABLE Registers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE income (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount INT NOT NULL,
    description VARCHAR(100),
    date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE expense (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount INT NOT NULL,
    description VARCHAR(100),
    date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE income
ADD card_id INT NOT NULL;



ALTER TABLE registers ADD email_verified_at DATETIME NULL,
ADD email_token VARCHAR(225) NOT NULL;

CREATE TABLE user_ips (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  ip_address VARCHAR(45) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE cards (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    card_number VARCHAR(20) NOT NULL,
    last_four CHAR(4) NOT NULL,

    card_type ENUM('VISA', 'MASTERCARD') NOT NULL,
    card_holder VARCHAR(100) NOT NULL,

    expiry_month TINYINT NOT NULL,
    expiry_year SMALLINT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES registers(id)
        ON DELETE CASCADE
);


ALTER TABLE cards ADD balance DECIMAL(10,2)  NOT NULL DEFAULT 0;


CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  icon VARCHAR(50),
  color VARCHAR(20)
);

INSERT INTO categories (name, icon, color) VALUES
('Food', '🍔', '#f97316'),
('Transport', '🚗', '#3b82f6'),
('Rent', '🏠', '#8b5cf6'),
('Shopping', '🛒', '#ec4899'),
('Bills', '💡', '#eab308');


ALTER TABLE expense
ADD category_id INT NOT NULL;


ALTER TABLE expense
ADD CONSTRAINT fk_expense_category
FOREIGN KEY (category_id)
REFERENCES categories(id)
ON DELETE RESTRICT;


SELECT id, category_id FROM expense;

CREATE TABLE category_limits (
  id INT AUTO_INCREMENT PRIMARY KEY,

  user_id INT NOT NULL,
  category_id INT NOT NULL,

  month TINYINT NOT NULL,   
  year SMALLINT NOT NULL,   

  limit_amount DECIMAL(10,2) NOT NULL,

   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  
  UNIQUE (user_id, category_id, month, year),


  FOREIGN KEY (user_id) REFERENCES registers(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
);



ALTER TABLE expense
ADD card_id INT NOT NULL;

ALTER TABLE expense
ADD CONSTRAINT fk_expense_card
FOREIGN KEY (card_id)
REFERENCES cards(id)
ON DELETE CASCADE;

USE smart_wallet;