<?php
require_once '_includes/pdoConnect.php';
require_once '_includes/authenticate.php';

//        session_start();
//        $_SESSION['username'] = $kNumber;
//        $_SESSION['authenticated'] = true;

$stmt = $db->prepare('SELECT module.moduleID, module.moduleName
FROM module, userModule
WHERE module.moduleID=userModule.moduleID AND userModule.kNumber=:kNumber');
$stmt->bindParam(':kNumber', $_SESSION['username']);
$stmt->execute();


class module {
    private $moduleID;
    private $moduleName;
    
    public function __get($name)
    {
        return $this->$name;
    }
}

$modules = $stmt->fetchAll(PDO::FETCH_CLASS, 'module');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Front Row | Home</title>
        <meta name="description" content="This is the homepage or dashboard of the LMS.">
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
            <a id="logout" href="logout.php">Logout</a>
        </nav>
        </header>
        <main>
            <article>
<!--  Just self contained content, other 'articles' could be general announcements, organisations, grades etc  -->
                <h2>Your Modules:</h2>
                <ul>
                <?php
//                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                    echo '<li><a href="module.php?moduleID='. $row['moduleID'] .'">Module: '. $row['moduleName'] .'</a></li>';
//                }
                ?>
<!--
                <?php foreach($modules as $key => $module) : ?>
                    <li><a href="module.php?moduleID=<?= $module->moduleID ?>">Module: <?= $module->moduleName ?> and Key <?= $key ?></a></li>
                <?php endforeach; ?>
-->
                   
       
                <?php foreach($modules as $module) : ?>
                    <li><a href="module.php?moduleID=<?= $module->moduleID ?>">Module <?= $module->moduleID ?>: <?= $module->moduleName ?></a></li>
                <?php endforeach; ?>

                </ul>
            </article>
            <article>
                <h2>Announcements</h2>
                <section>
                </section>
            </article>
        </main>
<!--
        <script>
            var logoff = document.getElementById("logout");

            logoff.onclick = function() {
                window.close();
            }
        </script>
-->
    </body>
</html>
