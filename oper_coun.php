<?php

include 'connect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// ______________________
$sql = "SELECT COUNT(*) FROM oper_find WHERE oper LIKE '%Beeline%'";
$res = $conn->query($sql);
$row = mysqli_fetch_row($res);
$total = $row[0];
echo "Beeline: " . $total ;
//echo $total;
$sql = "SELECT COUNT(*) FROM oper_find WHERE oper LIKE '%Magticom%'";
$res = $conn->query($sql);
$row = mysqli_fetch_row($res);
$total = $row[0];
echo "Magticom: " . $total ;
//echo $total;
$sql = "SELECT COUNT(*) FROM oper_find WHERE oper LIKE '%SilkNet%'";
$res = $conn->query($sql);
$row = mysqli_fetch_row($res);
$total = $row[0];
echo "SilkNet: " . $total ;
//echo $total;
$sql = "SELECT COUNT(*) FROM oper_find";
$res = $conn->query($sql);
$row = mysqli_fetch_row($res);
$total = $row[0];
echo "TOTAL: " . $total ;

if($total < 1){
    //echo $total;
$sql = "SELECT COUNT(*) FROM oper_find_dub_9_12";
$res = $conn->query($sql);
$row = mysqli_fetch_row($res);
$total = $row[0];
echo "TOTAL: " . $total ;
}


$conn->close();


// header("Location: index.php");
?>