<!DOCTYPE html>
<html>
<head>
    <title>Download HTML Folder</title>
</head>
<body>

<h2>Download HTML Folder</h2>

<p>Click the button below to download the HTML folder as a compressed archive.</p>

<form action="/bbb.php" method="post">
    <input type="hidden" name="download" value="true">
    <button type="submit" name="submit">Download</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download'])) {
    $file = '/var/www/html.zip';
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo 'File not found.';
    }
}
?>

</body>
</html>
