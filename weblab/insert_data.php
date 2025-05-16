<?php
include 'connect.php';
global $link;

$first_name =$_POST ['first_name']; 
$last_name = $_POST  ['last_name'];
$email = $_POST  ['email'];

// Inserare date
$sql = 'INSERT INTO persons (first_name, last_name, email) VALUES ("Peter", "Parker", "peterparker@mail.com")';
if (mysqli_query($link, $sql)) {
  echo 'Records inserted successfully.';
} else {
  echo 'ERROR: Could not able to execute ' . $sql . mysqli_error($link);
}

// Inchidere conexiune
mysqli_close($link);
?>