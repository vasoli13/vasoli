<?php


include 'connect.php';


// START_____/uploads_ში ყველა ფაილის წაშლა
require_once('files_delete.php');
// END_____/uploads_ში ყველა ფაილის წაშლა


// START_____/SQL კავშირი
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// END_____/SQL კავშირი


// START_____/TABLE_ში ჩანაწერების გაწმენდა
$sql = "TRUNCATE TABLE oper_find";
if ($conn->query($sql) === TRUE) {
    echo " TRUNCATE OK! ";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "TRUNCATE TABLE oper_find_dub_9_12";
if ($conn->query($sql) === TRUE) {
    echo " TRUNCATE OK! ";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
// END_____/TABLE_ში ჩანაწერების გაწმენდა


// START_____/ნომრების გაწმენდა
if (isset($_POST["num_filter"])) {
    $textarea = $_POST["num_filter"];

    $textarea = preg_replace('/[" +"]/', "", $textarea);
    $textarea = preg_replace('/-/', "", $textarea);
    $num   = explode("\n", (trim($textarea)));

    for ($x = 0; $x < 1; $x++) {
        foreach ($num as $text_string) {
            $text_string = str_replace(array("\n", "\r"), '', $text_string);
            $mb_strlen1 = strlen($text_string);
            $mb_strlen = $mb_strlen1;

            $pirveli_1 = mb_substr($text_string, 0, 1);
            $pirveli_3 = mb_substr($text_string, 0, 4);

            if (
                isset($_POST['dub']) &&
                $_POST['dub'] == 'Yes'
            ) {
                $sdsd = "oper_find";
            } else {
                $sdsd = "oper_find_dub_9_12";
            }

            if (($pirveli_3 == 9955 and $mb_strlen === 12) or ($pirveli_1 == 5 and $mb_strlen === 9)) {
                if (is_numeric($text_string)) {
                    if ($mb_strlen === 12) {
                        $toDelete = 3; // რამდენი სიმბოლო უნდა წაიშალოს
                        mb_internal_encoding("UTF-8");
                        $result = mb_substr($text_string, $toDelete);
                        $sql = "INSERT IGNORE INTO `$sdsd` (num) VALUES ('" . $result . "')";
                        if ($conn->query($sql) === TRUE) {
                            // echo " INSERT OK! ";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    } else {
                        $sql = "INSERT IGNORE INTO `$sdsd` (num) VALUES ('" . $text_string . "')";
                        if ($conn->query($sql) === TRUE) {
                            // echo " INSERT OK! ";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                // echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
// END_____/ნომრების გაწმენდა


if (
    isset($_POST['dub']) &&
    $_POST['dub'] == 'Yes'
) {
    $sdsd = "oper_find";
} else {
    $sdsd = "oper_find_dub_9_12";
}


// START_____/Beeline_ით oper შევსება
$conn->query("UPDATE `$sdsd` SET oper = 'Beeline'");
// END_____/Beeline_ით oper შევსება

// START_____/ინდექსის გამოყოფა
$conn->query("UPDATE `$sdsd` SET oper_id = LEFT(num,3)");
// END_____/ინდექსის გამოყოფა


// START_____/ოპერატორების გაწერა ინდექსით
$conn->query("UPDATE `$sdsd`, oper_index SET `$sdsd`.oper = oper_index.oper WHERE `$sdsd`.oper_id = oper_index.oper_index");
// END_____/ოპერატორების გაწერა ინდექსით


// START_____/ოპერატორების გაწერა 01_12_2022_all_იდან
$conn->query("UPDATE `$sdsd`, 01_12_2022_all SET `$sdsd`.oper = 01_12_2022_all.oper WHERE `$sdsd`.num = 01_12_2022_all.num");
// END_____/ოპერატორების გაწერა 01_12_2022_all_იდან


// START_____/ოპერატორების მიხედვით ფაილებად ჩაწერა
$name = $_POST['username'];
$name = str_replace(array("\n", "\r", "\t"), '_', $name);
$name = preg_replace('/[" "]/', "_", $name);
$name = preg_replace('/[":"]/', "-", $name);

if ($name == "") {
    $name = "traki";
} else {
    //echo "File NOT deleted!";
}

if (
    isset($_POST['dub']) &&
    $_POST['dub'] == 'Yes'
) 
{
    $conn->query("SELECT num FROM oper_find WHERE oper LIKE '%Beeline%' INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____Beeline.txt'");
    $conn->query("SELECT num FROM oper_find WHERE oper LIKE '%Magticom%' INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____Magticom.txt'");
    $conn->query("SELECT num FROM oper_find WHERE oper LIKE '%SilkNet%' INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____SilkNet.txt'");
    $conn->query("SELECT num FROM oper_find INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____All.txt'");
} else {
    $conn->query("SELECT num FROM oper_find_dub_9_12 WHERE oper LIKE '%Beeline%' INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____Beeline.txt'");
    $conn->query("SELECT num FROM oper_find_dub_9_12 WHERE oper LIKE '%Magticom%' INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____Magticom.txt'");
    $conn->query("SELECT num FROM oper_find_dub_9_12 WHERE oper LIKE '%SilkNet%' INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____SilkNet.txt'");
    $conn->query("SELECT num FROM oper_find INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/$name._____All.txt'");
}
// END_____/ოპერატორების მიხედვით ფაილებად ჩაწერა

$conn->close();

header("Location: index.php");
