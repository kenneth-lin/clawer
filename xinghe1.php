<?php

include('./lib/include.php');
include('./ext/include.php');

header('Content-Type: text/html; charset=UTF-8');

function writeData($data,$conn)
{
  for($i=0;$i<count($data);$i++){
    $temp = $data[$i];
    $url = $temp['main_link_href'];
    $title = ($temp['title']);
    $query = "INSERT INTO  url1(url, title) VALUES ('$url', '$title')";  
    $result = $conn->query($query);
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

$now_at = 0;
$name_ar = array('xhdd','lljj','jtll','xycs','rqjh','dsjq');
$number_ar = array(902,265,489,424,552,564);
$order = array(3,2,4,5,0,1);


$mysql_server_name="localhost"; 
$mysql_username="root"; 
$mysql_password=""; 
$mysql_database="k_crawler"; 
$conn= new mysqli($mysql_server_name, $mysql_username,$mysql_password,$mysql_database);
$conn->set_charset("utf8");

$add_order = 0;

for($at=0;$at<count($order);$at++){

$cate = $name_ar[$order[$at]];
$number_index = $number_ar[$order[$at]];
echo $cate.'     '; 
$main_params = '{
    "table_name":"xinghe",
    "description":"This is for Rqyh",
    "main_block":".blockLink",
    "start_path":"https://www.23uup.com/{0}/",
    "host":"https://www.23uup.com",
    "next_link":{"current":null,"next":null},
    "attribute":{"main_link_href":"","title":"span"}
}';

str_replace('{0}',$cate,$main_params);





$url_array = array();
for($i=2;$i<$number_index;$i++){
  $t_var = json_decode($main_params);
  $t_var->start_path = $t_var->host.'/'.$cate.'/index_'.$i.'.html';
  array_push($url_array,json_encode($t_var));
}

$sqlReadyData = array();
for($i=0;$i<count($url_array);$i++){
  $data = clawerData($url_array[$i]);
  echo $i.'     ';
  if(count($data)==0) echo 'no data     ';
  writeData($data,$conn);
}
if ($add_order> 40) {  
  $conn->close();
  $conn= new mysqli($mysql_server_name, $mysql_username,$mysql_password,$mysql_database);
  $conn->set_charset("utf8");
  $add_order = 0;
}
$add_order++;

}

$conn->close();
//mysql_close($conn);  
echo 'end';






?>