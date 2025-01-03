MedSave Project
MedSave is a platform designed to facilitate the buying and donating of second-hand medical equipment. It provides a simple and secure environment for users to list their medical products for sale or donation. This project utilizes a database with three main tables: user, product, and category.

Prerequisites
Before you begin, ensure that you have the following installed on your local machine:

XAMPP: A free and open-source cross-platform web server solution stack package. It includes Apache and MySQL.
Database Setup: A MySQL database with the following tables: user, product, and category.
Database Schema
The database schema for MedSave consists of three primary tables: user, product, and category. Below is a detailed description of each table structure.

user Table
The user table contains information about users who are listed on the platform.

Column Name	Data Type	Null	Default Value	Description
user_id	INT(50)	No	AUTO_INCREMENT	Primary key for the user
firstName	VARCHAR(25)	No	None	User's first name
lastName	VARCHAR(25)	No	None	User's last name
email	VARCHAR(100)	No	None	User's email address
contact	INT(10)	No	None	User's contact number
address	VARCHAR(100)	No	None	User's address
password	VARCHAR(255)	No	None	User's encrypted password
product Table
The product table stores details about the medical products listed by users.

Column Name	Data Type	Null	Default Value	Description
product_id	INT(11)	No	AUTO_INCREMENT	Primary key for the product
name	VARCHAR(255)	No	None	Product name
image	VARCHAR(255)	No	None	Product image
price	DECIMAL(10,2)	Yes	NULL	Product price
description	TEXT	No	None	Product description
cat_id	INT(11)	No	None	Foreign key referencing the category table
usage_duration	VARCHAR(255)	No	None	Duration of product usage
user_id	INT(11)	No	None	Foreign key referencing the user table
category Table
The category table defines categories for the medical products listed on the platform.

Column Name	Data Type	Null	Default Value	Description
cat_id	INT(11)	No	AUTO_INCREMENT	Primary key for the category
name	VARCHAR(255)	No	None	Category name
image	VARCHAR(255)	No	None	Category image
created_at	TIMESTAMP	No	CURRENT_TIMESTAMP()	Timestamp for when category was created
description	TEXT	No	None	Category description
Setting Up the Project
To set up and run the MedSave project on your local machine, follow these steps:

1. Install XAMPP
Download and install XAMPP from the following link:
https://www.apachefriends.org/index.html

2. Start XAMPP Services
Launch the XAMPP control panel and start the following services:

Apache (for the web server)
MySQL (for the database)
3. Set Up the Database
Open phpMyAdmin by navigating to http://localhost/phpmyadmin/ in your browser.
Create a new database for the project, e.g., medsave_db.
Run the following SQL queries to create the user, product, and category tables.
SQL Queries for Table Creation
sql
Copy code
CREATE TABLE `user` (
  `user_id` INT(50) AUTO_INCREMENT PRIMARY KEY,
  `firstName` VARCHAR(25) NOT NULL,
  `lastName` VARCHAR(25) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `contact` INT(10) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL
);

CREATE TABLE `category` (
  `cat_id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `description` TEXT NOT NULL
);

CREATE TABLE `product` (
  `product_id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10,2) DEFAULT NULL,
  `description` TEXT NOT NULL,
  `cat_id` INT(11) NOT NULL,
  `usage_duration` VARCHAR(255) NOT NULL,
  `user_id` INT(11) NOT NULL,
  FOREIGN KEY (`cat_id`) REFERENCES `category`(`cat_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`)
);
4. Configure the Project
Place the project files in the htdocs directory of your XAMPP installation (typically located in C:/xampp/htdocs/).
Open your browser and navigate to http://localhost/medsave (or the appropriate directory if you named it differently).
Ensure that the database connection and other configurations are set up correctly.
Running the Project
Start both Apache and MySQL in the XAMPP control panel.
Open your web browser and go to http://localhost/medsave (or the correct directory name).
Follow the on-screen instructions to interact with the MedSave platform.
Contact Information
If you encounter any issues or have any inquiries, please feel free to reach out.
