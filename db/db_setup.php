<?php
// db/db_setup.php
$servername = "localhost";
$username = "root"; // default XAMPP MySQL username
$password = "";     // default XAMPP MySQL password
$dbname = "class_rep_management";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
if (!$conn->select_db($dbname)) {
    die("Error selecting database: " . $conn->error);
}

// SQL to create tables
$tableSql = "
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS faculties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS class_reps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    faculty_id INT,
    semester VARCHAR(10),
    stage VARCHAR(5),
    phone VARCHAR(15),
    mpesa_account VARCHAR(50),
    attendance INT DEFAULT 0,
    enrolled BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (faculty_id) REFERENCES faculties(id)
);

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_rep_id INT,
    amount DECIMAL(10, 2) DEFAULT 2000.00,
    semester VARCHAR(10),
    paid BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (class_rep_id) REFERENCES class_reps(id)
);
";

// Execute the table creation SQL
if ($conn->multi_query($tableSql)) {
    echo "Tables created successfully<br>";
} else {
    die("Error creating tables: " . $conn->error);
}

// Insert a default admin user (username: admin, password: password123)
$adminPassword = md5('password123');
$adminSql = "INSERT IGNORE INTO admins (username, password) VALUES ('admin', '$adminPassword')";
if ($conn->query($adminSql) === TRUE) {
    echo "Default admin user created successfully<br>";
} else {
    echo "Error creating default admin user: " . $conn->error;
}

$conn->close();
?>
