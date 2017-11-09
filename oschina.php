<?php

include('./lib/include.php');
include('./ext/include.php');

header('Content-Type: text/html; charset=UTF-8');


$main_params = '{
    "table_name":"oschina",
    "description":" This is for oschina.",
    "main_block":".news-list",
    "start_path":"https://www.oschina.net/project/tags",
    "host":"https://www.oschina.net/",
    "next_link":{"current":".active","next":null},
    "attribute":{"main_content":".joke-main-content-text","who":".joke-user-info-nickname"}
}';
EXT_Template::add_header("./template/tieba_header.html");
EXT_Template::add_host('https://www.oschina.net/');

$crawler = new Crawler_Data();
$crawler->init($main_params);

echo "<body><div style='width:1024px;margin: 10px auto;'>";
$crawler->get_count_run_dom(2,true);
echo "</div></body>";

?>