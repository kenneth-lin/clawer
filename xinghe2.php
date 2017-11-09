<?php

include('./lib/include.php');
include('./ext/include.php');

header('Content-Type: text/html; charset=UTF-8');

function writeData($data,$conn)
{
  for($i=0;$i<count($data);$i++){
    $temp = $data[$i];
    $url = $temp['main_link_href'];
    $title = mysql_real_escape_string($temp['title']);
    $query = "INSERT INTO  urls(url, title) VALUES ('$url', '$title')";  
    $result = mysql_query($query,$conn);
  }
}

function findUrlData($conn)
{
    $reslist = array();
    $res=mysql_query("SELECT url,title from urls limit 100", $conn);
    while($row = mysql_fetch_row($res)){
        $row1['url'] = $row[0];
        $row1['title'] = $row[1];
        $reslist[] = $row1;
    }
    return $reslist;
}

function writeContentData($data,$conn)
{
  for($i=0;$i<count($data);$i++){
    $temp = $data[$i];
    $url = $temp['url'];
    $title = mysql_real_escape_string($temp['title']);
    $context = mysql_real_escape_string($temp['context']);
    $query = "INSERT INTO  context(url,title,description,created_time) VALUES ('$url', '$title','$context', now())";  
    $result = mysql_query($query,$conn);
  }
}

function clawerData($params)
{
  $data = array();
  try{
    $crawler = new Crawler_Data();
    $crawler->init($params);
    $crawler->get_count_run_dom(1,false);
    $data = $crawler->get_out_data();
  }catch(Exception $e){

  }
  return $data;
}


$main_params = '{
    "table_name":"xinghe",
    "description":"This is for Rqyh",
    "main_block":".blockLink",
    "start_path":"https://www.23uup.com/rqjh/",
    "host":"https://www.23uup.com",
    "next_link":{"current":null,"next":null},
    "attribute":{"main_link_href":"","title":"span"}
}';

$main_params2 = '{
    "table_name":"xinghe",
    "description":"This is for Rqyh",
    "main_block":".section",
    "start_path":"https://www.23uup.com/rqjh/",
    "host":"https://www.23uup.com",
    "next_link":{"current":null,"next":null},
    "attribute":{"context":".txt"}
}';

//EXT_Template::add_header("./template/tieba_header.html");
//EXT_Template::add_host('https://www.23uup.com/');

$mysql_server_name="localhost"; 
$mysql_username="root"; 
$mysql_password=""; 
$mysql_database="k_crawler"; 
$conn=mysql_connect($mysql_server_name, $mysql_username,$mysql_password);
mysql_select_db($mysql_database);
mysql_query("set names 'utf8'");


$url_array = array();
$url_path = findUrlData($conn);
for($i=0;$i<count($url_path);$i++){
  $t_var = json_decode($main_params2);
  $t_var->start_path = $url_path[$i]['url'];
  array_push($url_array,json_encode($t_var));
}


$sqlReadyData = array();
for($i=0;$i<count($url_array);$i++){
  $data = clawerData($url_array[$i]);
  $data[0]['url'] = $url_path[$i]['url'];
  $data[0]['title'] = $url_path[$i]['title'];
  writeContentData($data,$conn);
}

mysql_close($conn);  
echo 'end';






?>