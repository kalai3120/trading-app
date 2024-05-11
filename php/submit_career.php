<?php
// Database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Form data
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];

// File upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["resume"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check file size
if ($_FILES["resume"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow only pdf and doc/docx files
if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
  echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
    // Insert data into database
    $sql = "INSERT INTO career (full_name, email, mobile, resume) VALUES ('$full_name', '$email', '$mobile', '$target_file')";
    if ($conn->query($sql) === TRUE) {
      echo "Career information submitted successfully.";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

$conn->close();
?>
