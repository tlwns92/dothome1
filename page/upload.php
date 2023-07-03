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
$sql = "SELECT * FROM upload WHERE session_id = '$sessionId' ORDER BY upload_num DESC";
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



                        echo '<div class="record" id="record-'.$uploadNum.'">';
                        echo '<div class="category-buttons" id="category-buttons-'.$uploadNum.'">';
                        echo '<button class="category-button active" id="dicom-'.$uploadNum.'"  data-category="original" onclick="changeCategory('.$uploadNum.', \'original\', \''.$filePath.'\')">DICOM Image</button>';
                        echo '<button class="category-button" id="analyzed-'.$uploadNum.'" data-category="analysis" onclick="changeCategory('.$uploadNum.', \'analysis\', \''.$filePath.'\')">Analyzed Image</button>';
                        echo '<button class="category-button" id="result-'.$uploadNum.'"  data-category="result" onclick="changeCategory('.$uploadNum.', \'result\', \''.$filePath.'\')">Result Value</button>';
                        echo '</div>';
                        echo '<div id="viewercontainer-' . $uploadNum . '" style="display: flex; justify-content: center; align-items: center;">';
                        echo '<div class="dicomViewerport" id="dicomViewerport-' . $uploadNum . '" style="height: 300px; width: 300px; margin-right:50px;"></div>';
                        echo '<div class="download-container" style="  text-align: center;">';
                        echo '<br><br><h4>Download analyzed data as a zip file.</h4><br><button class="download-button">Download</button>';
                        echo '</div>';
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

var recordsElement = document.getElementById("records");

// 버튼 클릭 이벤트 핸들러
function handleDownload(event) {
  var button = event.target;
  var recordElement = button.closest(".record");
  var uploadNum = recordElement.id.split("-")[1];

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "/controller/zip_download.php?filename=1000001.zip", true);
  xhr.responseType = "blob";

  xhr.onload = function() {
    if (xhr.status === 200) {
      var blob = new Blob([xhr.response], { type: "application/zip" });
      var downloadLink = document.createElement("a");
      downloadLink.href = window.URL.createObjectURL(blob);
      downloadLink.download = "1000001.zip";
      downloadLink.click();
      window.URL.revokeObjectURL(downloadLink.href); // 메모리 해제
    }
  };

  xhr.send();
}

// 이벤트 위임을 통해 버튼 클릭 이벤트 처리
recordsElement.addEventListener("click", function(event) {
  var target = event.target;
  if (target.classList.contains("download-button")) {
    handleDownload(event);
  }
});
</script>
