<?php

include('./lib/include.php');
include('./ext/include.php');
include('./config/include.php');
header("Content-type: text/html; charset=utf-8"); 
EXT_Template::add_header('./template/header.html');

echo '<div class="content">';
EXT_Template::add_header('./template/selector.html');


if(isset($_REQUEST['action'])){
    $action = $_REQUEST['action'];
    if($action == 'search'){
        include('./view/search.php');
        return;
    }
}

EXT_Template::add_header('./template/params.html');

if(isset($_REQUEST['action'])){
    $action = $_REQUEST['action'];
    
    if($action == 'show'){
        include('./view/show.php');
    }else if($action == 'add'){
        include('./view/add.php');
    }else if($action == 'edit'){
        include('./view/edit.php');
    }else if($action == 'capture'){
        include('./view/capture.php');
    }else if($action == 'bat'){
        include('./view/bat.php');
    }else if($action == 'del'){
        include('./view/del.php');
    }else if($action == 'progress'){
        include('./view/progress.php');
    }else if($action == 'ls_table'){
        include('./view/ls_table.php');
    }

}else{
    include('./view/show.php');
}
echo '</div>';

?>