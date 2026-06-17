<?php
$servername = "localhost";
$username = "a30079025_Macka"; 
$password = "a30079025_db_sixseven";
$database = "a30079025_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your data object
$data = [
    "subject" => "002",
    "class" => "Euclid",
    "description" => "...",
    "containment" => "...",
    "image" => "images/800px-SCP002.jpg"
];

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO scp (subject, class, description, containment, image) VALUES (?, ?, ?, ?, ?)");

// "ssss" means we are passing 4 strings
$stmt->bind_param("sssss", $data['subject'], $data['class'], $data['description'], $data['containment'], $data['image']);

// Execute the statement
if ($stmt->execute()) {
    echo "<h2> Success!</h2>";
    echo "<p>New record for " . $data['subject'] . " created successfully.</p>";
    echo "<p>New Row ID is: " . $conn->insert_id . "</p>";
} else {
    echo "<h2> Error</h2>";
    echo "<p>Execution failed: " . $stmt->error . "</p>";
}

// Close connections
$stmt->close();
$conn->close();
?>