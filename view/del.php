<?php


if(isset($_REQUEST['params'])){
    $main_params = $_REQUEST['params'];
    MySQLClass::deleteClawerData($main_params);
    echo 'Table is removed.';
}else{
    echo 'You could remove table by defined "table_name".';
}



?>