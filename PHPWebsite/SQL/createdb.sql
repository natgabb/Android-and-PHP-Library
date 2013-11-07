USE team3;

-- Dropping tables product and users.
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Users;

-- Creating product table
CREATE TABLE Product(
	_id INT unsigned PRIMARY KEY auto_increment,
	Quantity INT,
	Genre ENUM('RPG','Puzzle','Racing','FPS','Sport','Strategy','Platform','Fighting','Indie','Educational'),
	Platform ENUM('PC','Xbox','Wii','PS3'),
	Name VARCHAR(50),
	Image VARCHAR(150),
	Description VARCHAR(1000),
	Price DOUBLE(10,2),
	Taxable TINYINT(1),
	CreateDate DATETIME NOT NULL,
	ModifyDate DATETIME
);

-- Creating users table
CREATE TABLE Users(
  _id INT UNSIGNED PRIMARY KEY auto_increment,
  Username VARCHAR(45) UNIQUE NOT NULL,
  Password VARCHAR(45) NOT NULL default '',
  FirstName VARCHAR(50),
  LastName VARCHAR(50),
  Status TINYINT(1),
  CreateDate DATETIME NOT NULL,
  ModifyDate DATETIME
);