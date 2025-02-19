Installation and Setup
Follow these steps to set up the website on your local machine or server:

Prerequisites

PHP: Version 7.0 or higher.
MySQL: For database management.
Web Server: Apache.

STEPS

1. IDE Installation:
Install vs code editor from its official website.
XAMPP/WAMP For local development and testing.
2. Set Up the Database:
 Create a MySQL database named `ttc_db`.
 Import the SQL file (`embedded with html file`) located in each folder.
3. Configure Database Connection:
   Open `db/connection.php` and update the database credentials:
php
     $host = "localhost";
     $user = "root";
     $password = "";
     $database = "ttc_db";
4. Upload Files to Server:
   Upload the project files to your web server's root directory (e.g., `htdocs` for XAMPP).
5. Access the Website:
   Open your browser and navigate to `http://localhost/TTC/index.php `.
