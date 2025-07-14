<?php
require_once("connection.php");

if(!empty($_POST['shout'])) {
    $shout = mysqli_real_escape_string($link, $_POST['shout']);
    mysqli_query($link, "INSERT INTO shouts(shout_text) VALUES ('$shout')") 
        or die(mysqli_error($link));
}
?>

<html>
<head>
    <meta http-equiv="refresh" content="0; url=index.php">
    <title>Redirecting...</title>
</head>
<body>
    
    <p>Please wait.. (^~^)</p>
</body>
</html>