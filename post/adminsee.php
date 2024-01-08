<?php
session_start();
require_once "../database/dbconnect.php";
$sql = "SELECT * FROM contact";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Messages</title>
</head>
<body>

    <h2>Contact Messages</h2>

    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Number</th>
            <th>Subject</th>
            <th>Message</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['number']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['message']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>