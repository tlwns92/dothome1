<?php
include '../db.php';

function mq($sql){
  global $conn;
  return $conn->query($sql);
}

// 회원가입 폼 데이터 검증
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $confirmpassword = test_input($_POST["confirmpassword"]);
  $check_sub_button = test_input($_POST['check_sub_button']);

  $sql_check = "SELECT * FROM users WHERE email='$email'";
  $result_check = $conn->query($sql_check);
  $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
  $email_check = mq("select * from users where email='$email'");
  $email_check = $email_check->fetch_array();
  

   
  if($check_sub_button=="1" &&preg_match($emailRegex, $email) && !$email_check['email'] && preg_match("/^(?=.*[!@#$%^&*])(?=.*[a-zA-Z])(?=.*[0-9]).{8,15}$/", $password) && $password === $confirmpassword) {
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
    if(mq($sql)){
      echo "<script>showThankYou();</script>";
      echo "<script>document.getElementById('email').value = '';</script>";
      echo "<script>document.getElementById('password').value = '';</script>";
      echo "<script>document.getElementById('confirmpassword').value = '';</script>";
      $conn->close();
    }else{
      echo "회원가입에 실패했습니다!";
      $conn->close();
    }

  }else if(!empty($email)){
    if (!preg_match($emailRegex, $email)) {
      echo "이메일 형식에 맞지 않습니다.";
    }else{
      if($email_check['email']){
        echo "이미 사용중인 이메일입니다.";
      }else{
        if (!$email_check['email'] && preg_match("/^(?=.*[!@#$%^&*])(?=.*[a-zA-Z])(?=.*[0-9]).{8,15}$/", $password)) {
          if(empty($confirmpassword)){
            echo "비밀번호 확인을 입력하세요.";
          }else if(!empty($confirmpassword) && $password !== $confirmpassword){
            echo "비밀번호 확인이 다릅니다.";
          }else if(!empty($confirmpassword) && $password === $confirmpassword){
            echo "사용 가능한 이메일과 비밀번호 입니다.";
          }
        } else {
          echo "비밀번호는 특수문자 1개 이상을 포함한 8자리~15자리로 입력해주세요.";
        }
      }
    }
  } else if(empty($email) || empty($password) || empty($confirmpassword)){
    echo "입력란을 채워주세요.";
  } else if (empty($email) && empty($password) && empty($confirmpassword)){
    echo " ";
  }
}




function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
 ?>