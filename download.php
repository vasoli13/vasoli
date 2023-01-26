<?php

$name = $_POST['file_name'];

$file_name = $name;

$num_filter_file = "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$file_name";
if (file_exists($num_filter_file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($num_filter_file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($num_filter_file));
    readfile($num_filter_file);
    exit;
}

header("Location: index.php");
?>