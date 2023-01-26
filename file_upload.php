<?php

include 'connect.php';

// START_____/uploads_ში ყველა ფაილის წაშლა
require_once('files_delete.php');
// END_____/uploads_ში ყველა ფაილის წაშლა


//  START_____/ფაილის ატვირთვა
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'File Upload') {
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $file = basename($fileName, ".txt"); // $file is set to "index"

    $newFileName = $fileName;
    // check if file has one of the following extensions
    $allowedfileExtensions = array('csv', 'txt');

    if (in_array($fileExtension, $allowedfileExtensions)) {
      // directory in which the uploaded file will be moved
      $uploadFileDir = 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/Uploads File/';
      $dest_path = $uploadFileDir . $newFileName;

      if (move_uploaded_file($fileTmpPath, $dest_path)) {
        $message = 'File is successfully uploaded.';
      } else {
        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
      }
    } else {
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
  } else {
    $message = 'There is some error in the file upload. Please check the following error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  }
}
// END_____/ფაილის ატვირთვა


$conn = new mysqli($servername, $username, $password, $dbname);


// START_____/TABLE_ში ჩანაწერების გაწმენდა
$conn->query("TRUNCATE	TABLE oper_find");
// END_____/TABLE_ში ჩანაწერების გაწმენდა


// START_____/ფაილის ატვირთვა
if (!empty($_POST['username'])) {
  $conn->query("LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/Uploads File/$newFileName' IGNORE INTO TABLE oper_find (num)");
}
if (empty($_POST['username'])) {
  $conn->query("LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/Uploads File/$newFileName' IGNORE INTO TABLE oper_find (num)");
}
// END_____/ფაილის ატვირთვა 


// START_____/Beeline_ით oper შევსება
$conn->query("UPDATE oper_find SET oper = 'Beeline'");
// END_____/Beeline_ით oper შევსება


// START_____/ინდექსის გამოყოფა
$conn->query("UPDATE oper_find SET oper_id = LEFT(num,3)");
// END_____/ინდექსის გამოყოფა


// START_____/ოპერატორების გაწერა ინდექსით
$conn->query("UPDATE oper_find, oper_index SET oper_find.oper = oper_index.oper WHERE oper_find.oper_id = oper_index.oper_index");
// END_____/ოპერატორების გაწერა ინდექსით


// START_____/ოპერატორების გაწერა 01_12_2022_all_იდან
$conn->query("UPDATE oper_find, 01_12_2022_all SET oper_find.oper = 01_12_2022_all.oper WHERE oper_find.num = 01_12_2022_all.num");
// END_____/ოპერატორების გაწერა 01_12_2022_all_იდან


// START_____/ოპერატორების მიხედვით ფაილებად ჩაწერა
$name = $_POST['username'];
$name = str_replace(array("\n", "\r", "\t"), '_', $name);
$name = preg_replace('/[" "]/', "_", $name);
$name = preg_replace('/[":"]/', "-", $name);

if ($name == "") {
  $name = "traki";
} else {
  //echo "username???";
}

$conn->query("SELECT num FROM oper_find WHERE oper LIKE '%Beeline%' INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____Beeline.txt'");
$conn->query("SELECT num FROM oper_find WHERE oper LIKE '%Magticom%' INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____Magticom.txt'");
$conn->query("SELECT num FROM oper_find WHERE oper LIKE '%SilkNet%' INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____SilkNet.txt'");
$conn->query("SELECT num FROM oper_find INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____All.txt'");
// END_____/ოპერატორების მიხედვით ფაილებად ჩაწერა


$conn->close();


header("Location: index.php");
