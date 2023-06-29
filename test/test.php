<!DOCTYPE html>
<html>
<head>
  <title>DICOM Viewer</title>
  <script src="https://unpkg.com/cornerstone-core/dist/cornerstone.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dicom-parser@1.8.21/dist/dicomParser.min.js"></script>
  <script src="https://unpkg.com/cornerstone-wado-image-loader/dist/cornerstoneWADOImageLoader.bundle.min.js"></script>
</head>
<body>
  <div id="records">
    <div class="dicomViewport" id="dicomViewport-1" style="height: 300px; width: 300px;"></div>
    <div class="image-container" id="image-container-1"></div>
  </div>

  <script>
    window.addEventListener('load', function() {
      var filePath = "./uploads/dd.dcm";
      loadDICOM(filePath, "dicomViewport-1");
    });

    function loadDICOM(fileURL, elementId) {
      var element = document.getElementById(elementId);
      var imageId = "wadouri:" + fileURL;

      cornerstone.enable(element);
      cornerstoneWADOImageLoader.external.cornerstone = cornerstone;
      cornerstoneWADOImageLoader.external.dicomParser = dicomParser;

      cornerstoneWADOImageLoader.configure({
        beforeSend: function(xhr) {
        }
      });

      cornerstone.loadImage(imageId).then(function(image) {
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
      originalButton.textContent = "Original";

      var analysisButton = document.createElement("button");
      analysisButton.className = "category-button";
      analysisButton.setAttribute("data-category", "analysis");
      analysisButton.textContent = "Analysis";

      var resultButton = document.createElement("button");
      resultButton.className = "category-button";
      resultButton.setAttribute("data-category", "result");
      resultButton.textContent = "Result";

      categoryButtonsElement.appendChild(originalButton);
      categoryButtonsElement.appendChild(analysisButton);
      categoryButtonsElement.appendChild(resultButton);

      var dicomViewport = document.createElement("div");
      dicomViewport.className = "dicomViewport";
      dicomViewport.id = "dicomViewport-" + uploadNum;
      dicomViewport.style.width = "300px";
      dicomViewport.style.height = "300px";

      var imageContainer = document.createElement("div");
      imageContainer.className = "image-container";
      imageContainer.id = "image-container-" + uploadNum;

      recordElement.appendChild(categoryButtonsElement);
      recordElement.appendChild(dicomViewport);
      recordElement.appendChild(imageContainer);

      recordsElement.appendChild(recordElement);

      loadDICOM(filePath, dicomViewport.id);
    }
  </script>
</body>
</html>
