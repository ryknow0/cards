<?php
//This is the main page of the application, we will destroy and start a new session
//every time we come to this page so that we can start the game over
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Draw 2 cards
    <form action="drawtwo.php" method="get">
       <input type="submit" value="Draw">
   </form>

</body>
</html>