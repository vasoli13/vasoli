<?php

include 'connect.php';

$dir = 'C:/ProgramData/MySQL/MySQL Server 8.0' . '/uploads';
// $leave = array('index.html', '.htaccess');
		
foreach (glob($dir . '/*') as $file) {
	unlink($file);
 }

 
 $conn = new mysqli($servername, $username, $password, $dbname);

 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// TABLE_ში ჩანაწერების გაწმენდა
$conn->query("TRUNCATE	TABLE oper_find") ;
$conn->query("TRUNCATE	TABLE oper_find_dub_9_12") ;


$conn->close();


header("Location: index.php");