<?php
$servername = "localhost:3306";
$database = "admin_zombiewifi_";
$username = "zombie_admin";
$password = "Qlc85%j1";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}
 
echo "Connected successfully";
 
$sql = "INSERT INTO puntodeacceso (r_version, r_architecture, r_boardname) VALUES ('Thom', 'Vial', 'thom.v@some.com')";
if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
} else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
?>