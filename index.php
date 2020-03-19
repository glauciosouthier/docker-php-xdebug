<?php header('Content-Type: text/html; charset=iso-8859-1'); ?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
 <body>
 
 <?php 
  echo "<h1 class=`bd-title`>Blog</h1>";
 $db= mysqli_connect('mysql', 'root', 'root','blog');
 if (!$db) {
    echo "Não foi possível selecionar o banco de dados.".mysqli_error($db) ;
    exit;
  }
  $sql = "SELECT * FROM post ";
  $result = mysqli_query($db, $sql);
    if($result){
        echo '<table class="table table-bordered">';
        echo `<thead class="thead-light">`;
            echo ' <th>id</th>';
            echo "<th>title</th>";
            echo "<th>content</th>";
            echo "<th>status</th>";
            echo "<th>created at</th>";
       echo "</thead>";
       echo '<tbody>';
    while($row = mysqli_fetch_array($result)){
        echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['content'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['date_created'] . "</td>";
        echo "</tr>";
    }
    echo '</tbody>';
    echo "</table>";
    // Free result set
    mysqli_free_result($result);
    mysqli_close($db);
} ?>
 </body>
</html>