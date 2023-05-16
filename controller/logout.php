<?php
 
        @session_start();
        $result = session_destroy(); //세션을 닫아준다 
 
        if($result) { //세션닫기에 성공하면 
?>
        <script>
                alert("로그아웃 되었습니다.");
                location.replace("../index.php"); //다시 처음 페이지로 돌아간다
        </script>
<?php   }
?>