DROP DATABASE IF EXISTS inventory_management;
CREATE DATABASE inventory_management DEFAULT CHARACTER SET utf8;
use inventory_management;

CREATE TABLE IF NOT EXISTS DEVICE (
  id                        INT unsigned NOT NULL AUTO_INCREMENT,
  parent_id                 INT DEFAULT 0,
  id_cate					INT NOT NULL,
  serial_number             VARCHAR(50) NOT NULL,
  product_number			VARCHAR(50) NOT NULL,
  name                      VARCHAR(100) NOT NULL,
  brand_id                  INT NOT NULL,
  specifications            TEXT,
  status                    INT DEFAULT 0,
  stock_date                DATETIME DEFAULT CURRENT_TIMESTAMP,
  warranty_period           DATETIME,
  created_time          	DATETIME DEFAULT CURRENT_TIMESTAMP,
  update_time           	DATETIME DEFAULT CURRENT_TIMESTAMP,
  is_deleted                BOOLEAN NOT NULL DEFAULT FALSE,
  primary key(id)
);

CREATE TABLE IF NOT EXISTS BRAND (
  id                        INT unsigned NOT NULL AUTO_INCREMENT,
  brand_name       			VARCHAR(100) NOT NULL,
  created_time          	DATETIME DEFAULT CURRENT_TIMESTAMP,
  update_time           	DATETIME DEFAULT CURRENT_TIMESTAMP,
  is_deleted                BOOLEAN NOT NULL DEFAULT FALSE,
  primary key(id)
);

CREATE TABLE IF NOT EXISTS CATEGORY(
  id                        INT unsigned NOT NULL AUTO_INCREMENT,
  id_parent 				INT,
  category_name             VARCHAR(100) NOT NULL,
  created_time          	DATETIME DEFAULT CURRENT_TIMESTAMP,
  update_time           	DATETIME DEFAULT CURRENT_TIMESTAMP,
  is_deleted                BOOLEAN NOT NULL DEFAULT FALSE,
  primary key(id)
);

CREATE TABLE IF NOT EXISTS USER (
  id                        INT unsigned NOT NULL AUTO_INCREMENT,
  user_name                 VARCHAR(100) NOT NULL,
  position                  VARCHAR(100) NOT NULL,
  level                     INT,
  created_time          	DATETIME DEFAULT CURRENT_TIMESTAMP,
  update_time           	DATETIME DEFAULT CURRENT_TIMESTAMP,
  is_deleted                BOOLEAN NOT NULL DEFAULT FALSE,
  primary key(id)
);

CREATE TABLE IF NOT EXISTS FILE (
  id                        INT unsigned NOT NULL AUTO_INCREMENT,
  relate_id                 INT,
  relate_name               INT,
  path                      TEXT,
  type                      VARCHAR(50),
  created_time          	DATETIME DEFAULT CURRENT_TIMESTAMP,
  update_time           	DATETIME DEFAULT CURRENT_TIMESTAMP,
  is_deleted                BOOLEAN NOT NULL DEFAULT FALSE,
  primary key(id)
);

CREATE TABLE IF NOT EXISTS BorrowDevice (
  id                        INT unsigned NOT NULL AUTO_INCREMENT,
  borrower_id               INT NOT NULL,
  approved_id               INT,
  handover_id               INT,
  device_id                 INT NOT NULL,
  note                      TEXT,
  status                    INT,
  borrow_date               DATETIME NOT NULL,
  approved_date             DATETIME,
  delivery_date             DATETIME,
  returnee_date             DATETIME NOT NULL,
   created_time          	DATETIME DEFAULT CURRENT_TIMESTAMP,
  update_time           	DATETIME DEFAULT CURRENT_TIMESTAMP,
  is_deleted                BOOLEAN NOT NULL DEFAULT FALSE,
  primary key(id)
)