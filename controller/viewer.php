<?php
include '/var/www/html/db.php';

function mq($sql){
    global $conn;
    return $conn->query($sql);
}

if (isset($_POST['uploadNum'])) {
    $uploadNum = $_POST['uploadNum'];
    $sessionId = $_POST['sessionId'];
    $sql = "SELECT * FROM upload WHERE upload_num = '$uploadNum' and session_id = '$sessionId'";
    $result = mq($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $uploadRanFile = $row['upload_ran_file'];
            $uploadFile = $row['upload_file'];
            $uploadRan = pathinfo($uploadRanFile, PATHINFO_FILENAME);
            $uploadPath = $row['upload_path'];
            $DICOMPath = $uploadPath . $uploadRan . '/' . $uploadRan . '.png';
            $AnalyzedPah = $uploadPath . $uploadRan . '/analyze.png';
            $status = $row['status'];
            $Z_score = $row['z_score'];
            $result_Value = $row['result_value'];

            if  ($status == "Analyzing") {
                echo '<div class="view-container1" id="view-container1" style="height: 400px; width: 870px; text-align: center; display: flex; justify-content: center; align-items: center;">';
                echo '<div class="dicom-div" id="dicom-div" style="height: 100%; width: 100%; text-align: center;">';
                echo '<img src="../images/analyzing_icon.gif" alt="analyzing GIF" style="width: 300px;">';
                echo '<h2 style="margin-top:-30px;">Analyzing</h2>';
                echo '<h3>Please wait a moment.</h3>';
                echo '</div>';
                echo '</div>';
            }
            else if ($status == "Error") {
                echo '<div class="view-container1" id="view-container1" style="height: 400px; width: 870px; text-align: center; display: flex; justify-content: center; align-items: center;">';
                echo '<div class="dicom-div" id="dicom-div" style="height: 100%; width: 100%; text-align: center;">';
                echo '<h2 style="margin-top:150px; color: red;">Analysis failed.</h2>';
                echo '<h3>I don\'t think this file is a dicom file or a chest dicom.</h3>';
                echo '</div>';
                echo '</div>';

            }
            else if ($status == "Complete") {
                echo '<div class="view-container1" id="view-container1" style="height: 1220px; width: 870px; text-align: center;">';

                echo '<div class="dicom-div" id="dicom-div" style="height: 400px; width: 400px;  justify-content: center; align-items: center;  display: inline-block;">';
                echo '<h2 style="display: block;">&lt;Dicom Image&gt;</h2>';
                echo '<img src="' . $DICOMPath . '" alt="Image" style="width: 300px; height: 300px;">';
                echo '</div>';

                echo '<div class="analyzed-div" id="analyzed-div" style="height: 400px; width: 400px; text-align: center;  display: inline-block;">';
                echo '<h2 style="display: block;">&lt;Analyzed Image&gt;</h2>';
                echo '<img src="' . $uploadPath . $uploadRan . '/analyze.png' . '" alt="Image" style="width: 300px; height: 300px;">';
                echo '</div>';


                echo '<div class="graph-div" id="graph-div" style="justify-content: center; align-items: center;  display: inline-block;">';
                echo '<div id="z-score-container" data-z-score="' . htmlspecialchars($Z_score) . '"></div>';
                echo '<h2 style="display: block;">&lt; Z - Score &gt;</h2>';
                //echo '<canvas id="graphCanvas" width="500" height="250"></canvas>';
                echo '<canvas id="graphCanvas" width="700" height="450"></canvas>';
                //echo json_encode(array("z_score" => $Z_score));
                echo '</div>';

               $result_value_array = json_decode($result_Value, true);


                echo '<div class="table-div" id="table-div" style="justify-content: center; align-items: center;  display: inline-block;">';
                echo '<h2 style="display: block;">&lt; Result Value &gt;</h2>';
                echo '<table>';
                echo '<thead>';
    		echo '<tr>';
   		echo '<th>Carina_angle</th>';
    		echo '<th>&nbsp;&nbsp;&nbsp;&nbsp;Rt Lower CB</th>';
    		echo '<th>Rt Upper CB</th>';
    		echo '<th>Aortic Knob</th>';
    		echo '</tr>';
    		echo '</thead>';
    		echo '<tbody>';
    		echo '<tr>';
		echo '<td>' . ($result_value_array[0] === null ? '-' : number_format((float)$result_value_array[0], 4)) . '</td>';
		echo '<td>' . ($result_value_array[1] === null ? '-' : number_format((float)$result_value_array[1], 4)) . '</td>';
		echo '<td>' . ($result_value_array[2] === null ? '-' : number_format((float)$result_value_array[2], 4)) . '</td>';
		echo '<td>' . ($result_value_array[3] === null ? '-' : number_format((float)$result_value_array[3], 4)) . '</td>';
    		echo '</tr>';
    		echo '</tbody>';
    		echo '<thead>';
    		echo '<tr>';
    		echo '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DAO</th>';
    		echo '<th>Pulmonary Conus</th>';
    		echo '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LAA</th>';
    		echo '<th>Lt Lower CB</th>';
    		echo '</tr>';
    		echo '</thead>';
    		echo '<tbody>';
    		echo '<tr>';
    		echo '<td>' . ($result_value_array[4] === null ? '-' : number_format((float)$result_value_array[4], 4)) . '</td>';
		echo '<td>' . ($result_value_array[5] === null ? '-' : number_format((float)$result_value_array[5], 4)) . '</td>';
		echo '<td>' . ($result_value_array[6] === null ? '-' : number_format((float)$result_value_array[6], 4)) . '</td>';
		echo '<td>' . ($result_value_array[7] === null ? '-' : number_format((float)$result_value_array[7], 4)) . '</td>';
    		echo '</tr>';
    		echo '</tbody>';
    		echo '</table>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
}

?>

