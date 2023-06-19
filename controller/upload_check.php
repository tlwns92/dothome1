<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$sessionId = session_id();
$response = [
    'status' => 'success',
    'message' => '',
    'uploadedFiles' => []
];

if (!empty($_FILES) && isset($_POST['uploadPath'])) {
    $uploadPath = $_POST['uploadPath'];
    $fileArray = $_FILES['files'];
    include '../db.php';

    function mq($sql) {
        global $conn;
        return $conn->query($sql);
    }

    foreach ($fileArray['tmp_name'] as $key => $tmpFile) {
        $fileName = $fileArray['name'][$key];
        $randomFileName = uniqid() . ".dcm";
        $targetFile = $uploadPath . $randomFileName;

        if (!is_dir($uploadPath) && !empty($tmpFile)) {
           mkdir($uploadPath, 0777, true);
        }

        if (move_uploaded_file($tmpFile, $targetFile)) {
            $sql = "INSERT INTO upload (session_id, upload_file, upload_ran_file, upload_path, upload_time) VALUES ('$sessionId', '$fileName', '$randomFileName', '$uploadPath', NOW())";
            $result = $conn->query($sql);

            if ($result) {
                $uploadNum = $conn->insert_id;
                $response['uploadedFiles'][] = [
                    'filePath' => $targetFile,
                    'uploadNum' => $uploadNum
                ];

                doWriteLog("File Upload successful(upload_check.php): tmpFile - $tmpFile, filePath - $targetFile");
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to save file information to the database.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'File Upload failed';
            doWriteLog("File Upload failed(upload_check.php): tmpFile - $tmpFile, targetFile - $targetFile ");
        }
    }
    $conn->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error uploading files';
}

header('Content-Type: application/json');
echo json_encode($response);

function doWriteLog($str) {
    $logPath = '/var/www/html/logs/abc_log.txt';
    $fp = fopen($logPath, 'a');
    fwrite($fp, date('Y-m-d H:i:s') . ' ' . $str . PHP_EOL);
    fclose($fp);
}
?>
