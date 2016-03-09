<?php
require_once '_includes/pdoConnect.php';

if (isset($_POST['login'])) {
    $kNumber = trim($_POST['kNumber']);
    $pwd = trim($_POST['pwd']);
    $stmt = $db->prepare('SELECT pwd FROM user WHERE kNumber = :kNumber');
    $stmt->bindParam(':kNumber', $kNumber);
    $stmt->execute();
    $stored = $stmt->fetchColumn();
    if (password_verify($pwd, $stored)) {
        session_start();
        session_regenerate_id(true);
        $_SESSION['username'] = $kNumber;
        $_SESSION['authenticated'] = true;
        header('Location: home.php');
        exit;
    } else {
        $error = 'Login failed. Check kNumber and password.';
    }
}

?>
<!DOCTYPE html>
<html id="landingPage" lang="en">
    <head>
        <title>Front Row | LMS</title>
        <meta name="description" content="This is a prototype learning management system.">
        <!-- Content below could be put in a PHP include -->
        <meta charset="utf-8">
        
        <!-- FONT –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
        
        <!-- CSS –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <link rel="stylesheet" href="_css/main.css">
<!-- Probably want to add font awesome in       <link rel="stylesheet" href="/fonts/css/font-awesome.css">-->

        <link rel="shortcut icon" href="/_img/favicon.ico" type="image/x-icon">
    </head>
    <body>
<!--    <h1>Login</h1>-->
    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    }
    ?>
        <div class="login-card">
            <a href="home.php"><img class="logo" src="_img/kulogo.png" alt="Kingston University"></a>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
                <p>
                    <label for="kNumber">kNumber:</label>
                    <input type="username" name="kNumber" id="kNumber" placeholder="K Number">
                </p>
                <p>
                    <label for="pwd">Password:</label>
                    <input type="password" name="pwd" id="pwd" placeholder="Password">
                </p>
                <p>
                    <input type="submit" name="login" id="login" value="Log In">
                </p>
            </form>
        </div>
    </body>
</html>