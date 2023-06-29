// 중복확인 버튼 클릭시 실행되는 함수
function selectCategory(category) {
  window.location.href = category;
}
// get the current page URL and extract the category from it
var currentPageURL = window.location.href;
var category = currentPageURL.substring(currentPageURL.lastIndexOf('/')+1);


Dropzone.options.demoUpload = {
  maxFilesize: 10,
  init: function() {
    var self = this;
    var uploadPath; // 업로드 경로 변수

    // maxFiles 옵션 추가
    this.options.maxFiles = 10;

    this.on("addedfiles", function(files) {
      // 파일이 추가될 때 실행되는 이벤트 핸들러
      var fileArray = Array.from(files); // 파일 배열

      var validFiles = [];
      var invalidFiles = [];

      // 파일을 확인하여 유효한 파일과 유효하지 않은 파일로 분류
      fileArray.forEach(function(file) {
        var extension = file.name.split(".").pop().toLowerCase();
        console.log("filename : " + file.name);
        console.log("ext : " + extension);
        if (extension === "dicom" || extension === "dcm") {
          // 파일 크기가 1MB를 초과하지 않는 경우에만 유효한 파일로 분류
          if (file.size <= self.options.maxFilesize * 1024 * 1024) {
            validFiles.push(file);
            console.log("valid dicom file : " + file.name);
          } else {
            var logMessage =
              "Upload failed(dropzone): file size over filename - " +
              file.name +
              " , filesize - " +
              (file.size / (1024 * 1024)).toFixed(2) +
              "MB";
            doWriteLog(logMessage);
            invalidFiles.push(file);
          }

        } else {
          invalidFiles.push(file);
          console.log("invalid dicom file : " + file.name);
        }
      });

      if (validFiles.length === 0) {
        // 유효한 파일이 없을 때
        var logMessage =
          "Upload failed(dropzone): It's not a Dicom file  filename - " +
          invalidFiles.map((file) => file.name).join(", ");
        doWriteLog(logMessage);
        self.removeAllFiles(); // 모든 파일 제거
        alert("Only" + self.options.maxFilesize +"MB DICOM files can be uploaded.");
        return;
      }

      if (validFiles.length > 5) {
        // 5개 이상의 유효한 파일을 추가하려고 할 때
        var logMessage =
          "Upload failed(dropzone): Upload File Count Exceeded ";
        doWriteLog(logMessage);
        self.removeAllFiles(); // 모든 파일 제거
        alert("Only 5 files can be uploaded.");
        return;
      }

      // 임의의 폴더 경로 생성
      var timestamp = Date.now().toString();
      var randomNum = Math.floor(Math.random() * 1000).toString();
      uploadPath = "../upload/" + timestamp + randomNum + "/";
      console.log("upload path : " + uploadPath);
      console.log("valid file : " + validFiles);

      // FormData 객체 생성
      var formData = new FormData();
      formData.append("uploadPath", uploadPath); // 업로드 경로 추가
      validFiles.forEach(function(file) {
        console.log("File:", file); // 파일 정보 출력
        formData.append("files[]", file); // 유효한 파일 추가
      });
      console.log("formData:", formData);
      doWriteLog(
        "script to upload_check.php: success - " +
          validFiles.map((file) => file.name).join(", ") +
          ", fail - " +
          invalidFiles.map((file) => file.name).join(", ")
      );

      // AJAX 요청을 통해 폴더 생성과 파일 이동 또는 복사 작업 수행
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "/controller/upload_check.php");

      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            console.log("Files uploaded successfully");
            try {
              var response = JSON.parse(xhr.responseText);
              if (response.status === "success") {
                console.log("File information saved to the database.");
                response.uploadedFiles.forEach(function(uploadedFile) {
                displayDICOM(uploadedFile.filePath, uploadedFile.uploadNum);
                });
              } else {
                console.error(
                  "Failed to save file information to the database."
                );
              }
            } catch (error) {
              console.error("Error parsing server response: ", error);
            }
          } else {
            console.log("Error uploading files");
          }
        }
      };

      xhr.send(formData);

      // 유효하지 않은 파일 알림 출력
      if (invalidFiles.length > 0) {
        var invalidFileNames = invalidFiles.map(function(file) {
          return file.name;
        });
        var alertMessage =
          "Only" + self.options.maxFilesize +"MB DICOM files can be uploaded.\nExcluded files: " +
          invalidFileNames.join(", ");
        alert(alertMessage);
      }
    });

    this.on("complete", function() {
      self.removeAllFiles();
    });
  },
};


function loadDICOM(fileURL, elementId) {
    const element = document.getElementById(elementId);
    const imageId = `wadouri:${fileURL}`;

    cornerstone.enable(element);
    cornerstoneWADOImageLoader.external.cornerstone = cornerstone;
  cornerstoneWADOImageLoader.external.dicomParser = dicomParser;

cornerstoneWADOImageLoader.configure({
    beforeSend: function(xhr) {
    }
});

cornerstone.loadImage(imageId).then(image => {
    cornerstone.displayImage(element, image);
});
}

function displayDICOM(filePath, uploadNum) {
  var recordsElement = document.getElementById("records");

  var recordElement = document.createElement("div");
  recordElement.className = "record";

  var categoryButtonsElement = document.createElement("div");
  categoryButtonsElement.className = "category-buttons";

  var originalButton = document.createElement("button");
  originalButton.className = "category-button";
  originalButton.setAttribute("data-category", "original");
  originalButton.textContent = "DICOM Image";
  originalButton.id = "dicom-" + uploadNum;

  var analysisButton = document.createElement("button");
  analysisButton.className = "category-button";
  analysisButton.setAttribute("data-category", "analysis");
  analysisButton.textContent = "Analyzed Image";
  analysisButton.id = "analyzed-" + uploadNum;

  var resultButton = document.createElement("button");
  resultButton.className = "category-button";
  resultButton.setAttribute("data-category", "result");
  resultButton.textContent = "Result Value";
  resultButton.id = "result-" + uploadNum;

  categoryButtonsElement.appendChild(originalButton);
  categoryButtonsElement.appendChild(analysisButton);
  categoryButtonsElement.appendChild(resultButton);

  var viewContainer = document.createElement("div");
  viewContainer.id = "view-container-" + uploadNum;

  var dicomViewport = document.createElement("div");
  dicomViewport.className = "dicomViewerport";
  dicomViewport.id = "dicomViewerport-" + uploadNum;
  dicomViewport.style.width = "300px";
  dicomViewport.style.height = "300px";

  var imageContainer = document.createElement("div");
  imageContainer.className = "image-container";
  imageContainer.id = "image-container-" + uploadNum;

  viewContainer.appendChild(dicomViewport);
  viewContainer.appendChild(imageContainer);

  recordElement.appendChild(categoryButtonsElement);
  recordElement.appendChild(viewContainer);
  recordsElement.appendChild(recordElement);

  loadDICOM(filePath, dicomViewport.id);
}

function doWriteLog(logMessage) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/controller/write_log.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log("Log written successfully");
      } else {
        console.log("Error writing log");
      }
    }
  };

  xhr.send("logMessage=" + encodeURIComponent(logMessage));
}
