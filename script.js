
// 중복확인 버튼 클릭시 실행되는 함수
function selectCategory(category) {
  window.location.href = category;
}
// get the current page URL and extract the category from it
var currentPageURL = window.location.href;
var category = currentPageURL.substring(currentPageURL.lastIndexOf('/')+1);





$(document).ready(function(e) { 
  $(".check").on("keyup", function(){ //check라는 클래스에 입력을 감지
      var email = $("#email").val(); 
      var password = $("#password").val();
      var confirmpassword= $("#confirmpassword").val();
      var submitBtn = $('#submit-btn');

      $.post( //post방식으로 id_check.php에 입력한 userid값을 넘깁니다
        "controller/signup_check.php",
        {email : email, password: password, confirmpassword: confirmpassword},  
        function(data){ 
          if(data){ //만약 data값이 전송되면
            $("#check_string").html(data); //div태그를 찾아 html방식으로 data를 뿌려줍니다.
            $("#check_string").css("color", "#F00"); //div 태그를 찾아 css효과로 빨간색을 설정합니다
            if(data ==="사용 가능한 이메일과 비밀번호 입니다."){
              // submitBtn.css("background-image", "url('./images/menu-wrapper-bg.png')"); // 배경 이미지 변경
              submitBtn.css("opacity", "1");
              submitBtn.css("cursor", "pointer")
              submitBtn.prop('disabled', false); // 버튼 활성화
            }else{
              // submitBtn.css("background-image", "url('./images/gray_button_bg.png')"); // 배경 이미지 변경
              // submitBtn.css("opacity", "0.5");
              // submitBtn.css("cursor", "not-allowed");
              submitBtn.prop('disabled', true); // 버튼 비활성화
            }
          }
        }
      );
  });
});

let prism = document.querySelector(".rec-prism");

function showSignup(){
  prism.style.transform = "translateZ(-100px)";
}
function showLogin(){
  prism.style.transform = "translateZ(-100px) rotateY( 90deg)";
}
function showForgotPassword(){
  prism.style.transform = "translateZ(-100px) rotateY( -180deg)";
}

function showSubscribe(){
prism.style.transform = "translateZ(-100px) rotateX( -90deg)";
}

function showContactUs(){
  prism.style.transform = "translateZ(-100px) rotateY( -90deg)";
}

function showThankYou(){

prism.style.transform = "translateZ(-100px) rotateX( 90deg)";
}

function sign_showThankYou(){
  
  document.getElementById("check_sub_button").value = "1";

  var email = $("#email").val(); 
  var password = $("#password").val();
  var confirmpassword= $("#confirmpassword").val();
  var submitBtn = $('#submit-btn');
  var check_sub_button= document.getElementById("check_sub_button").value;



  $.post( //post방식으로 id_check.php에 입력한 userid값을 넘깁니다
  "controller/signup_check.php",
  {email : email, password: password, confirmpassword: confirmpassword, check_sub_button: check_sub_button},  
  function(data){ 
    if(data){ //만약 data값이 전송되면
      $("#check_string").html(data); //div태그를 찾아 html방식으로 data를 뿌려줍니다.
      $("#check_string").css("color", "#F00"); //div 태그를 찾아 css효과로 빨간색을 설정합니다
      if(data ==="회원가입에 실패했습니다!"){
        submitBtn.css("background-image", "url('./images/gray_button_bg.png')"); // 배경 이미지 변경
        submitBtn.prop('disabled', true); // 버튼 비활성화
        document.getElementById("check_sub_button").value = "2";
      }
    }
  }
);
  prism.style.transform = "translateZ(-100px) rotateX( 90deg)";
  }

  
  function logincheck(){
    var login_email= $("#login-email").val();
    var login_password = $("#login-password").val();
  
    $.post(
      "controller/login.php",
      {login_email : login_email, login_password: login_password},
      function(data){
        // 서버로부터 받아온 데이터를 처리합니다.
        // 데이터가 'User not found'인 경우, alert 창을 띄웁니다.
        if (data === 'User not found') {
          alert('User not found');
        }
        // 데이터가 'Incorrect password'인 경우, alert 창을 띄웁니다.
        else if (data === 'Incorrect password') {
          alert('Incorrect password');
        }
        // 데이터가 성공적으로 전송된 경우, index.php로 이동합니다.
        else {
          
          window.location.replace('index.php');
        }
      }
    );
  }

  

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



  // const dropZone = document.getElementById("dropzone");

  // // 드래그 이벤트 처리
  // ["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
  //   dropZone.addEventListener(eventName, preventDefaults, false);
  // });
  
  // function preventDefaults(e) {
  //   e.preventDefault();
  //   e.stopPropagation();
  // }
  
  // // 파일 업로드 처리
  // ["dragenter", "dragover"].forEach(eventName => {
  //   dropZone.addEventListener(eventName, highlight, false);
  // });
  
  // ["dragleave", "drop"].forEach(eventName => {
  //   dropZone.addEventListener(eventName, unhighlight, false);
  // });
  
  // function highlight(e) {
  //   dropZone.classList.add("highlight");
  // }
  
  // function unhighlight(e) {
  //   dropZone.classList.remove("highlight");
  // }
  
  // dropZone.addEventListener("drop", handleDrop, false);
  
  // function handleDrop(e) {
  //   e.preventDefault();
  //   e.stopPropagation();
  
  //   let dt = e.dataTransfer;
  //   let files = dt.files;
  
  //   // 파일 업로드를 위한 FormData 객체 생성
  //   let formData = new FormData();
  //   formData.append("image", files[0]);
  
  //   // XMLHttpRequest 객체 생성
  //   let xhr = new XMLHttpRequest();
  //   xhr.open("POST", "upload_check.php", true);
  //   xhr.onload = function () {
  //     if (xhr.status === 200) {
  //       console.log(xhr.responseText);
  //     }
  //   };
  //   xhr.send(formData);
  
  //   // 이미지 미리보기 생성
  //   // let img = document.createElement("img");
  //   // img.file = files[0];
  //   // dropZone.appendChild(img);
  
  //   // let reader = new FileReader();
  //   // reader.onload = (function (aImg) {
  //   //   return function (e) {
  //   //     aImg.src = e.target.result;
  //   //   };
  //   // })(img);
  //   // reader.readAsDataURL(files[0]);
  //}