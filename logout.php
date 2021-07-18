<?php
require 'database.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Poeisis Animal Shop </title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/main.css" rel="stylesheet"/>
    <link rel="shortcut icon" type="image/jpg" href="favicon.ico" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<style>
    body {
    font-family: "Montserrat", sans-serif;
    background-image: url("https://media.giphy.com/media/3ohhwNqFMnb7wZgNnq/giphy.gif");
    color: white;
}
</style>

</head>
<body>

<br>
<br>
<br>
<br>


<div class="container center-wrapper text-center">
    <?php
    unset($_SESSION);
    session_destroy();
    header( "refresh:5;url=login.php" );
    ?>
    <h1>Logged Out</h1>
    <p>Thank you for using Poiesis Animal Shop</p>

    <p class="text-muted">Click the button below if you've not been redirected in 5 second(s).</p>
    <a class="btn btn-primary" href="login.php" role="button">Redirect</a>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>
