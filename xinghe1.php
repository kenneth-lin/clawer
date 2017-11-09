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
    $query = "INSERT INTO  urls(url, title) VALUES ('$url', '$title')";  
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


$main_params = '{
    "table_name":"xinghe",
    "description":"This is for Rqyh",
    "main_block":".blockLink",
    "start_path":"https://www.23uup.com/xhdd/",
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
$conn= new mysqli($mysql_server_name, $mysql_username,$mysql_password,$mysql_database);
//mysqli_select_db($mysql_database);
$conn->set_charset("utf8");
//mysql_query("set names 'utf8'");


$url_array = array();
for($i=2;$i<902;$i++){
  $t_var = json_decode($main_params);
  $t_var->start_path = $t_var->host.'/xhdd/index_'.$i.'.html';
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
  echo $i.'     ';
  writeData($data,$conn);
}



// for($i=0;$i<count($sqlReadyData);$i++){
//     $temp = $sqlReadyData[$i];
//     $url = $temp['main_link_href'];
//     $title = $temp['title'];
//     $query = "INSERT INTO  urls(url, title) VALUES ('$url', '$title')";  
//     $result = mysql_query($query,$conn);
// }
$conn->close();
//mysql_close($conn);  
echo 'end';






?>