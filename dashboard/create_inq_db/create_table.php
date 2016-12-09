<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inq_dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// inq_database to create table
$sql = "CREATE TABLE user (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255),
	name VARCHAR(255),
	email VARCHAR(255),
	password CHAR(32),
	UNIQUE (email)
) DEFAULT CHARACTER SET utf8;
";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>