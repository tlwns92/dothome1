<?php
session_start();
$sessionId = session_id();

if (empty($sessionId)) {
    if (isset($_SESSION['sessionId'])) {
        $sessionId = $_SESSION['sessionId'];
    } else {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $_SESSION['sessionId'] = $ipAddress;
        $sessionId = $ipAddress;
    }
}

if (!isset($_SESSION['adc_ip'])) {
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $_SESSION['adc_ip'] = $ipAddress;
}

$adcIp = $_SESSION['adc_ip'];

//echo "adc_ip: " . $adcIp;

include '/var/www/html/db.php';

function mq($sql){
    global $conn;
    return $conn->query($sql);
}
$sql = "SELECT COUNT(*) AS recordCount FROM upload WHERE session_id = '$sessionId' AND upload_day= CURDATE()";
$result = mq($sql);
$row = $result->fetch_assoc();
$recordCount = $row['recordCount'];

$maxUploadCount = 5;

if ($recordCount >= $maxUploadCount) {
    $uploadDisabled = true;
    $uploadMessage = "You have reached the maximum upload limit.";
} else {
    $uploadDisabled = false;
    $uploadMessage = "";
}
?>

<style>
    h2 {
        font-size: 32px;
    }

    li {
        font-size: 22px;
        margin-bottom: 10px;
    }
</style>

<div id="wrapper">
    <div id="page">
        <div id="content">
            <h2><strong>Upload criteria</strong></h2>
            <ul>
                <li><strong>Up to 5 files</strong> can be uploaded at a time.</li>
                <li>Only <strong>dcm</strong> or <strong>dicom</strong> extension files up to 10mb can be uploaded.</li>
                <li>Files <strong>1 hour after</strong> uploading will be <strong>deleted.</strong></li>
            </ul><br>

            <div id="dropzone">
                <form action="/controller/upload_check.php" class="dropzone needsclick" id="demo-upload">
                    <div class="dz-message needsclick">
                        <span class="text">
                            <img src="../images/dicom_img.png" />
                            <strong>Drop Chest DICOM files here or click to upload.</strong><br>
                            <strong>today upload : <?php echo $recordCount; ?>/<?php echo $maxUploadCount; ?></strong>
                        </span>
                        <span class="plus">+</span>
                    </div>
                </form>
                <div id="select-file"></div>
            </div>
        </div>

<script>

function sendPostRequest(url, data, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    callback(xhr.responseText);
                } else {
                    console.error("POST request failed with status:", xhr.status);
                }
            }
        };
        xhr.send(data);
    }


 function changePage(page) {
        var sessionId = <?php echo json_encode($sessionId); ?>;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/controller/paging.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("select-file").innerHTML = xhr.responseText;

                    // 첫 번째 버튼의 ID 값을 viewer.php로 전송하여 record에 출력
                    var firstButton = document.querySelector(".file-button");
                    if (firstButton) {
                        var uploadNum = firstButton.id;
                        //var data = "uploadNum=" + uploadNum;
                        var data = "uploadNum=" + uploadNum + "&sessionId=" + sessionId;
                        sendPostRequest("../controller/viewer.php", data, function (response) {
                            document.getElementById("record").innerHTML = response;
                             var zScoreContainer = document.getElementById("z-score-container");
                             if (zScoreContainer) {
                                var zScoreValue = zScoreContainer.getAttribute("data-z-score");
                                drawGraph(JSON.parse(zScoreValue));
                             } else {
                             }

                        });
                    }
                } else {
                    console.error("페이지 업데이트에 실패했습니다. 상태 코드:", xhr.status);
                }
            }
        };
        xhr.send("sessionId=" + sessionId + "&page=" + page);
    }

changePage(1);



document.addEventListener("click", function (event) {
    if (event.target.classList.contains("file-button")) {
        var uploadNum = event.target.id;
        var sessionId = <?php echo json_encode($sessionId); ?>;
        var data = "uploadNum=" + uploadNum + "&sessionId=" + sessionId;
        sendPostRequest("../controller/viewer.php", data, function (response) {
            document.getElementById("record").innerHTML = response;
             var zScoreContainer = document.getElementById("z-score-container");
            if (zScoreContainer) {
                var zScoreValue = zScoreContainer.getAttribute("data-z-score");
                drawGraph(JSON.parse(zScoreValue));
            } else {
            }
        });
    }

});

function markCurrentButton(button) {
    // Remove 'current-file' class from all buttons
    var buttons = document.getElementsByClassName('file-button');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('current-file');
    }

    // Add 'current-file' class to the clicked button
    button.classList.add('current-file');
}




</script>

