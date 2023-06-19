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
<script src="https://unpkg.com/cornerstone-tools/dist/cornerstoneTools.js"></script>
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
            		echo '<button class="category-button" data-category="original">Original</button>';
            		echo '<button class="category-button" data-category="analysis">Analysis</button>';
            		echo '<button class="category-button" data-category="result">Result</button>';
            		echo '</div>';
                        echo '<div class="dicomViewerport" id="dicomViewerport-' . $uploadNum . '" style="height: 300px; width: 300px;"></div>';
                        echo '<div class="image-container" id="image-container-' . $uploadNum . '"></div>';
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





function handleUploadResponse(response) {
    const { status, message } = response;
    console.log(message);

    if (status === 'success') {
        const { files } = response;
        files.forEach(file => {
            const { fileName, filePath } = file;
            const uploadNum = getUploadNumFromFilePath(filePath);
            const elementId = `dicomViewerport-${uploadNum}`;

            // 이미지를 로드하고 뷰어를 추가
            loadDICOM(filePath, elementId);
        });
    }
}

// 파일 경로에서 업로드 번호를 추출
function getUploadNumFromFilePath(filePath) {
    const match = filePath.match(/dicomViewerport-(\d+)/);
    if (match) {
        return parseInt(match[1]);
    }
    return -1; // 유효하지 않은 파일 경로인 경우
}


</script>
