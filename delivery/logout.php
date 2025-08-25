<?php
session_start();
session_destroy();
header("Location: deliverylogin.php");
exit();
?>

