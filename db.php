<?php
// 데이터베이스 정보
$servername = "localhost";
$username = "mi2rl";
$password = "mi2rl1234";
$dbname = "test";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 에러 처리
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}