<?php
session_start();
$sessionId = session_id();

if (empty($sessionId)) {
    if (isset($_SESSION['sessionId'])) {
        $sessionId = $_SESSION['sessionId'];
    } else {
        $sessionId = generateSessionId();
        $_SESSION['sessionId'] = $sessionId;
    }
}

include '/var/www/html/db.php';

function mq($sql){
    global $conn;
    return $conn->query($sql);
}

$sql = "SELECT * FROM upload WHERE session_id = '$sessionId' ORDER BY upload_num ASC";
$result = mq($sql);
?>

<script src="https://unpkg.com/cornerstone-core/dist/cornerstone.js"></script>
<script src="https://unpkg.com/dicom-parser/dist/dicomParser.min.js"></script>
<script src="https://unpkg.com/cornerstone-wado-image-loader/dist/cornerstoneWADOImageLoader.bundle.min.js"></script>

<div id="wrapper">
    <div id="page">
        <div id="content">
            <div id="dropzone">
                <form action="/controller/upload_check.php" class="dropzone needsclick" id="demo-upload" >
                    <div class="dz-message needsclick">
                        <span class="text">
                            <img src="../images/dicom_img.png" />
                            Drop Chest DICOM files here or click to upload.
                        </span>
                        <span class="plus">+</span>
                    </div>
                </form>
            </div>
            <div id="records">
                <?php
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $uploadNum = $row['upload_num'];
                        $uploadFile = $row['upload_file'];
                        $uploadRanFile = $row['upload_ran_file'];
                        $uploadPath = $row['upload_path'];
                        $uploadTime = $row['upload_time'];
                        $filePath = $uploadPath . $uploadRanFile;

                        echo '<div class="record">';
                        echo '<div class="category-buttons">';
            		echo '<button class="category-button" id="dicom-'.$uploadNum.'"  data-category="original">DICOM Image</button>';
            		echo '<button class="category-button" id="analyzed-'.$uploadNum.'" data-category="analysis">Analyzed Image</button>';
            		echo '<button class="category-button" id="result-'.$uploadNum.'"  data-category="result">Result Value</button>';
            		echo '</div>';
                        echo '<div id="view-container-'. $uploadNum . '">';
                        echo '<div class="dicomViewerport" id="dicomViewerport-' . $uploadNum . '" style="height: 300px; width: 300px;"></div>';
                        echo '<div class="image-container" id="image-container-' . $uploadNum . '"></div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "Failed to save file information to the database.";
                }
                ?>
            </div>
        </div>

<script>

window.addEventListener('load', function() {
    <?php
    if ($result) {
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            $uploadNum = $row['upload_num'];
            $uploadRanFile = $row['upload_ran_file'];
            $uploadPath = $row['upload_path'];
            $filePath = $uploadPath . $uploadRanFile;
            echo 'loadDICOM("' . $filePath . '", "dicomViewerport-' . $uploadNum . '");';
        }
    }
    ?>
});


</script>
