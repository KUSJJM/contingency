<?php

require_once '_includes/pdoConnect.php';

if($db){
    echo 'Connection Successful';
} else {
    echo 'Connection Error';
}