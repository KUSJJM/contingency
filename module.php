<?php
require_once '_includes/pdoConnect.php';
require_once '_includes/authenticate.php';

if(isset($_GET['moduleID'])) {
    // Check that the kNumber hasn't already been registered
    $sql = 'SELECT COUNT(*) FROM module WHERE moduleID = :moduleID';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':moduleID', $_GET['moduleID']);
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        header('Location: home.php');
    } else {
        $sql = 'SELECT moduleName FROM module WHERE moduleID = :moduleID';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':moduleID', $_GET['moduleID']);
        $stmt->execute();
        $moduleName = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql = 'SELECT pageName FROM modulePage WHERE moduleID = :moduleID';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':moduleID', $_GET['moduleID']);
        $stmt->execute();
        
        $rows = $stmt->fetchAll();
    }
} else {
    header('Location: home.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Front Row | Module Page</title>
        <meta name="description" content="This is a module page.">
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
        <header>
            <img src="_img/kulogo.png" alt="Kingston University">
            <h1>Front Row</h1>
            <nav>
                <a href="home.php">Home</a>
                <a href="moduleCatalogue.php">Module Catalogue</a>
                <a href="#"><?= htmlentities($_SESSION['username']); ?> User Info</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>
        <nav>
            <?php
            foreach ($rows as $r) {
                    echo '<a href="#'. $r['pageName'] .'">'. $r['pageName'] .'</a>';
            }

//                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                    echo '<a href="#'. $r['pageName'] .'">'. $r['pageName'] .'</a>';
//                }
            ?>
        </nav>
        <main>
            <pre>
            <?php
                echo $_GET['moduleID'];
            ?>
            </pre>
            <h1>
                <?=$moduleName['moduleName']?>
            </h1>
            
            <?php
            foreach ($rows as $r) {
                    echo '<article id="'. $r['pageName'] .'"><p>Page: '. $r['pageName'] .'</p></article>';
                }
            ?>
        </main>
        <script src="_js/modulePages.js"></script>
    </body>
</html>