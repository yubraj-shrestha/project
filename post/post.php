<?php
session_start();
require_once "../database/dbconnect.php";
if(!isset($_SESSION['user_id']))
{
   echo '<script type="text/javascript">' .
             'confirm("' . 'Please login or create account email to send a message' . '");' .
             'setTimeout(function() {window.location.href="../login/sign.php";}, 1000);' .
             '</script>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username= $_POST["username"];
    $email=$_POST["email"];
    $number= $_POST["number"];
    $subject=$_POST["subject"];
    $message=$_POST["message"];

    // Fetch the user data from the database using the user_id from the session
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        // If the statement failed, show an error message
        echo "Error: " . mysqli_stmt_error($stmt);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Use the fetched email to check if the current user_id matches the user_id of the fetched user
    if ($_SESSION['user_id'] !== $user['id'])          
    {
        // Show an alert if the current user_id does not match the user_id of the fetched user
        echo '<script type="text/javascript">' .
             'confirm("' . 'Please use your account email to send a message' . '");' .
             'setTimeout(function() {window.location.href="../homepage.php";}, 1000);' .
             '</script>';
        exit();
    }

    // Insert the contact message into the database
    $sql="INSERT INTO contact ( `username`,`email`, `number`,`subject`,`message`) VALUES (?,?,?,?,?)";
    $stmt=mysqli_stmt_init($conn);
    $prepare=mysqli_stmt_prepare($stmt,$sql);

    if($prepare)
    {           
        mysqli_stmt_bind_param($stmt,"ssiss",$username,$user['email'],$number,$subject,$message);
        mysqli_stmt_execute($stmt);

        echo '<script type="text/javascript">' .
             'confirm("' . 'You messege is send' . '");' .
             'setTimeout(function() {window.location.href="../homepage.php";}, 1000);' . // Add a 1-second delay before redirecting
             '</script>'
             ;
        exit();
    }
}
?>