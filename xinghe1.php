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
for($i=2;$i<300;$i++){
  $t_var = json_decode($main_params);
  $t_var->start_path = $t_var->host.'/rqjh/index_'.$i.'.html';
  array_push($url_array,json_encode($t_var));
}



$sqlReadyData = array();
for($i=0;$i<count($url_array);$i++){
  // $crawler = new Crawler_Data();
  // $crawler->init($url_array[$i]);
  // $crawler->get_count_run_dom(1,false);
  // $data = $crawler->get_out_data();
  // for($j=0;$j<count($data);$j++){
  //   $temp = $data[$j];
  //   array_push($sqlReadyData,$temp);
  // }
  $data = clawerData($url_array[$i]);
  writeData($data,$conn);
}



// for($i=0;$i<count($sqlReadyData);$i++){
//     $temp = $sqlReadyData[$i];
//     $url = $temp['main_link_href'];
//     $title = $temp['title'];
//     $query = "INSERT INTO  urls(url, title) VALUES ('$url', '$title')";  
//     $result = mysql_query($query,$conn);
// }

mysql_close($conn);  
echo 'end';






?>