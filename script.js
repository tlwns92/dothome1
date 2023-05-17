
// 중복확인 버튼 클릭시 실행되는 함수
function selectCategory(category) {
  window.location.href = category;
}
// get the current page URL and extract the category from it
var currentPageURL = window.location.href;
var category = currentPageURL.substring(currentPageURL.lastIndexOf('/')+1);




  

  function uploadFiles() {
    var files = document.querySelectorAll("#demo-upload input[type=file]");
    var formData = new FormData();

    for (var i = 0; i < files.length; i++) {
      formData.append("file[]", files[i].files[0]);
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/controller/upload_check.php", true);

    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        alert("Upload complete!");
      }
    };

    xhr.send(formData);
  }



  