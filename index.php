<?php
include('./ext/include.php');
header('Content-Type: text/html; charset=UTF-8');
$queue = isset($_REQUEST['search'])?$_REQUEST['search']:'';

function findUrlData($str,$conn)
{
    $reslist = array();
    $str = "SELECT id,url,title from urls where title like '%$str%'";
    $res = $conn->query($str);
    $res->data_seek(1);
    //$res=mysql_query("SELECT id,url,title from urls where title like '%$str%'", $conn);
    while($row = $res->fetch_assoc()){
        $row1['id'] = $row['id'];
        $row1['url'] = $row['url'];
        $row1['title'] = $row['title'];
        $reslist[] = $row1;
    }
    return $reslist;
}

echo '<body style=""><div style="width:600px;margin:0 auto; padding:20px;">';

EXT_Template::add_header("./template/search.html");

if(empty($queue))
{}else{

$mysql_server_name="localhost"; 
$mysql_username="root"; 
$mysql_password=""; 
$mysql_database="k_crawler"; 
$conn=new mysqli($mysql_server_name, $mysql_username,$mysql_password,$mysql_database);
$conn->set_charset("utf8");

$data = findUrlData($queue,$conn);
echo 'Total is '.count($data).' on "'.$queue.'"';

echo '<div>';
for($i=0;$i<count($data);$i++){
    echo '<div class="data_class"><span><a href="'.$data[$i]['url'].'">'.$data[$i]['title'].'</a></span>';
    echo '</div>';
}
echo '</div>';

$conn->close();


}

echo '</div></body>';


?>