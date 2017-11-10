<?php

include('./lib/include.php');
include('./ext/include.php');
include('./config/include.php');

EXT_Template::add_header('./template/header.html');

echo '<div class="content">';
EXT_Template::add_header('./template/selector.html');
EXT_Template::add_header('./template/params.html');

if(isset($_REQUEST['action'])){
    $action = $_REQUEST['action'];
    if($action == 'show'){
        include('./view/show.php');
    }else if($action == 'add'){
        include('./view/add.php');
    }

}else{
    include('./view/show.php');
}
echo '</div>';

?>