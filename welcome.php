<?php
// Initialize the session
session_start();
 // if user is not logged in, they cannot access this Page
  if (empty($_SESSION['email'])) {
      header('location: index.php');
      exit;
    }
    ?>

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Home Page</h2>
</div>


<div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <a href="logout.php" class="btn">Sign Out of Your Account</a>
    </p>
</body>
</html>

