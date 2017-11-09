<?php

include('./lib/include.php');
include('./ext/include.php');

header('Content-Type: text/html; charset=UTF-8');


$main_params = '{
    "table_name":"haha",
    "description":"This is for haha.",
    "main_block":".container",
    "start_path":"http://www.haha.mx/",
    "host":"http://www.haha.mx/",
    "next_link":{"current":".pagination .current","next":".pagination .current"},
    "attribute":{"main_content":".joke-main-content-text","who":".joke-user-info-nickname"}
}';
EXT_Template::add_header("./template/header.html");
EXT_Template::add_host('http://www.haha.mx/');

$crawler = new Crawler_Data();
$crawler->init($main_params);

echo "<body><div style='width:1024px;margin: 10px auto;'>";
$crawler->get_count_run_dom(1,true);
echo "</div></body>";

?>