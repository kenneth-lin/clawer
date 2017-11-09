<?php
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
  static $recursive_counter = 0;
  if (++$recursive_counter > 1000) {
    die('possible deep recursion attack');
  }
  foreach ($array as $key => $value) {
    if (is_array($value)) {
      arrayRecursive($array[$key], $function, $apply_to_keys_also);
    } else {
      $array[$key] = $function($value);
    }
  
    if ($apply_to_keys_also && is_string($key)) {
      $new_key = $function($key);
      if ($new_key != $key) {
        $array[$new_key] = $array[$key];
        unset($array[$key]);
      }
    }
  }
  $recursive_counter--;
}

function JSON($array) {
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}
include('./lib/include.php');
include('./ext/include.php');

header('Content-Type: text/html; charset=UTF-8');


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


$crawler = new Crawler_Data();
$crawler->init($main_params);

//echo "<body><div style='width:1024px;margin: 10px auto;'>";
$crawler->get_count_run_dom(1,false);
$data = $crawler->get_out_data();
//echo JSON($data);
//echo "</div></body>";
echo ''.count($data);
for($i=0;$i<count($data);$i++){
    $temp = $data[$i];
    $url = $temp['main_link_href'];
    $title = $temp['title'];
    $query = "INSERT INTO  urls(url, title) VALUES ('$url', '$title')";  
    $result = mysql_query($query,$conn);
    //echo $query;
}

mysql_close($conn);  
echo 'end';






?>