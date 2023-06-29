<!DOCTYPE html>
<html>
<head>
  <title>DICOM Viewer</title>
  <script src="https://cdn.jsdelivr.net/npm/dwv@0.32.1/dist/dwv.min.js"></script>


</head>
<body>
  <div id="dwv"><div id='layerGroup0'></div></div>







  <script>
document.addEventListener('DOMContentLoaded', function (/*event*/) {
  // create the dwv app
  var app = new dwv.App();
  // initialise with the id of the container div
  app.init({
    dataViewConfigs: {'*': [{divId: 'layerGroup0'}]}
  });
  // load dicom data
 // app.loadURLs(['http://118.67.128.232:7070/test/uploads/up.dcm']);
 //app.loadURLs(['https://raw.githubusercontent.com/ivmartel/dwv/master/tests/data/bbmri-53323851.dcm']);
app.loadURLs(['http://118.67.128.232:7070/test/uploads/up.dcm']);


});

  </script>
</body>
</html>
