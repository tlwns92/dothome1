<!DOCTYPE html>
<html>
<head>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>ADC STUDY</title>
    <link href="http://fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css" />
 
 
 	

    <link rel="stylesheet" href=".\style.css">
    <script>
        function selectCategory(category) {
            window.location.href = category;
        }
    </script>
</head>
<body>
<?php
    if(isset($_GET['category'])) {
      $category = $_GET['category'];
      $filename = $category . ".html";

      if (file_exists($filename)) {
        include('common/header.html');
        include($filename);
        include('common/sidebar.html');

      } else {
        include('common/header.html');
        include('common/sidebar.html');
        include('error.html');

      }
    } else {
      include('common/header.html');
      include('page/home.html');
      include('common/sidebar.html');

    }
?>
<br><br><br><br>
<?php include('common/footer.html') ?>

<script>
    // get the current page URL and extract the category from it
    var currentPageURL = window.location.href;
    var category = currentPageURL.substring(currentPageURL.lastIndexOf('/')+1);

    // find the list item with the matching category and add "current_page_item" class to it
    var categoriesList = document.getElementById("categories_list");
    var categories = categoriesList.getElementsByTagName("li");
    for(var i = 0; i < categories.length; i++) {
        var categoryLink = categories[i].getElementsByTagName("a")[0];
        if(categoryLink.href.indexOf(category) !== -1) {
            categories[i].className += " current_page_item";
            break;
        }
    }
</script>

</body>
</html>
