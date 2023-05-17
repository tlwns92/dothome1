<?php
header("Access-Control-Allow-Origin: http://testadcstudy.dothome.co.kr");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$uploadDir = "../upload/";

if (!empty($_FILES)) {
  $tempFile = $_FILES["file"]["tmp_name"];
  $fileName = $_FILES["file"]["name"];
  $targetFile = $uploadDir . $fileName;

  move_uploaded_file($tempFile, $targetFile);
}
?>