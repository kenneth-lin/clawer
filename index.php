<?php
include('./ext/include.php');
header('Content-Type: text/html; charset=UTF-8');
$queue = isset($_REQUEST['search'])?$_REQUEST['search']:'';

function findUrlData($str,$conn)
{
    $reslist = array();
    $str = mysql_real_escape_string($str);
    $res=mysql_query("SELECT id,url,title from urls where title like '%$str%'", $conn);
    while($row = mysql_fetch_row($res)){
        $row1['id'] = $row[0];
        $row1['url'] = $row[1];
        $row1['title'] = $row[2];
        $reslist[] = $row1;
    }
    return $reslist;
}

echo '<body style=""><div style="width:600px;font-size:20px;margin:0 auto; padding:20px;">';

EXT_Template::add_header("./template/search.html");

if(empty($queue))
{}else{

$mysql_server_name="localhost"; 
$mysql_username="root"; 
$mysql_password=""; 
$mysql_database="k_crawler"; 
$conn=mysql_connect($mysql_server_name, $mysql_username,$mysql_password);
mysql_select_db($mysql_database);
mysql_query("set names 'utf8'");

$data = findUrlData($queue,$conn);
echo 'Total is '.count($data).' on "'.$queue.'"';

echo '<div>';
for($i=0;$i<count($data);$i++){
    echo '<div class="data_class"><span><a href="'.$data[$i]['url'].'">'.$data[$i]['title'].'</a></span>';
    echo '</div>';
}
echo '</div>';



}

echo '</div></body>';


?>