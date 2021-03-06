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
        //Get Module Name from module table
        $sql = 'SELECT moduleName FROM module WHERE moduleID = :moduleID';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':moduleID', $_GET['moduleID']);
        $stmt->execute();
        $moduleName = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Get Page Name from module page table
        $sql = 'SELECT pageName FROM modulePage WHERE moduleID = :moduleID';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':moduleID', $_GET['moduleID']);
        $stmt->execute();
        //Dump everything into rows object, maybe change variable to a more meaningful name
        $rows = $stmt->fetchAll();
        
        //Get user privs
        $sql = 'SELECT permission FROM userModule WHERE kNumber = :kNumber AND moduleID = :moduleID';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':moduleID', $_GET['moduleID']);
        $stmt->bindParam(':kNumber', $_SESSION['username']);
        $stmt->execute();
        
        if($stmt->fetchColumn() == 1){
            $priv = true;
        } else {
            $priv = false;
        }
        //echo $stmt->fetchColumn();

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
            <?php
                if($priv){
                    echo '<h2>User has lecturer/edit priveledges</h2>';
                    
                    //FILE UPLOAD SCRIPT START
                    
                    $max = 50 * 1024 * 1024;
                    $message = '';
                    if (isset($_POST['upload'])) {
                        $destination = '_uploads/';
                        if ($_FILES['filename']['error'] == 0) {
                            $result = move_uploaded_file($_FILES['filename']['tmp_name'], $destination . $_FILES['filename']['name']);
                            if ($result) {
                                $message = $_FILES['filename']['name'] . ' was uploaded successfully.';
                            } else {
                                $message = 'Sorry, there was a problem uploading ' .$_FILES['filename']['name'];
                            }
                        } else {
                            switch ($_FILES['filename']['error']) {
                                case 2:
                                    $message = $_FILES['filename']['name'] . ' is too big to upload.';
                                    break;
                                case 4:
                                    $message = 'No file selected.';
                                    break;
                                default:
                                    $message = 'Sorry, there was a problem uploading ' .$_FILES['filename']['name'];
                                    break;
                            }
                        }
                    }
            ?>
            <h1>Uploading Files</h1>
            <?php 
            if ($message) {
                echo "<p>$message</p>";
            }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <p>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max;?>">
                    <label for="filename">Select File:</label>
                    <input type="file" name="filename" id="filename">
                </p>
                <p>
                    <input type="submit" name="upload" value="Upload File">
                </p>
            </form>
            <?php
                    //FILE UPLOAD SCRIPT END
                } else {
                    echo '<h2>User has guest/student priveledges</h2>';
                }
            ?>
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