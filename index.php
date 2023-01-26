<!DOCTYPE html>


<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ტიტლიკანაპინგუინი Oper</title>
  <!-- CSS_style -->
  <link rel="stylesheet" type="text/css" href="./css.css">
  <!-- JS -->
  <script src="js.js"></script>

</head>


<body>


  <br>
  <br>

  
  <!-- START_____/კომბინირებული ნომრების გაწმენდა -->
  <form action="combo_filter.php" method="POST">
    <textarea name="username" rows="1" cols="51" placeholder='File Name...'></textarea>
    <textarea name="num_filter" rows="13" placeholder='Num...'></textarea>
    <input type="checkbox" name="dub" value="Yes" checked /> Removing Duplicates
    <input type="submit" name="send" value="Num Filter">
  </form>
  <!-- END_____/კომბინირებული ნომრების გაწმენდა -->


  <br>
  <br>


  <!-- START_____/file_ის ოპერატორებად დაყოფა -->
  <form method="POST" action="file_upload.php" enctype="multipart/form-data">
    <div>
      <textarea name="username" rows="1" cols="51" placeholder='File Name...'></textarea>
      <input type="file" name="uploadedFile" />
    </div>
    <input type="submit" name="uploadBtn" value="File Upload" />
  </form>
  <!-- END_____/file_ის ოპერატორებად დაყოფა -->


  <br>
  <br>


  <!-- START_____/ფაილის არჩევა და გადმოწერა -->
  <form method="POST" action="download.php" name="form1" enctype="multipart/form-data">
    <?php
    $path = 'C:/ProgramData/MySQL/MySQL Server 8.0' . '/uploads';
    ?>
    <select name="file_name" class="form-control">
      <option value="">Select a file</option>
      <?php
      foreach (scandir($path) as $obj) {
        if ($obj == '.' || $obj == '..') {
          continue;
        } elseif (!is_dir($path . '/' . $obj)) {
          echo '<option value="/' . $obj . '">' . $obj . '</option>';
        }
      }
      ?>
    </select>
    <input type="submit" name="downloadBtn" value="File Download" />
  </form>
  <!-- END_____/ფაილის არჩევა და გადმოწერა -->


  <br>
  <br>


  <!-- START_____/რაოდენობა -->
  <?php
  require_once('oper_coun.php');
  ?>
  <!-- END_____/რაოდენობა -->


  <br>
  <br>


  <!-- START_____/ფაილების წაშლა -->
  <form method="POST" action="files_delete.php" name="form1" enctype="multipart/form-data">
    <input type="submit" name="downloadBtn" value="All Files Delete" style="background-color: #f44336;" />
  </form>
  <!-- END_____/ფაილების წაშლა -->


</body>


</html>