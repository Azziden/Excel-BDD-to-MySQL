<?php
include "vendor/autoload.php";

include("csv.php");

$csv = new csv();
if ( isset($_POST['sub'])){
    $csv->import($_FILES['file']['tmp_name']);
    var_dump($_FILES['file']);
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" name="sub" value="Import">
</form>
    
</body>
</html>