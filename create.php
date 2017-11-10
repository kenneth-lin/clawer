<?php

include('./lib/include.php');
include('./ext/include.php');
include('./config/include.php');


header('Content-Type: text/html; charset=UTF-8');


// MySQLClass::createDatabase() or die('create database error');
// $conn = MySQLClass::createConn();
// MySQLClass::createTable($conn,'first_test') or die('create table error');
// MySQLClass::alterTable($conn,'first_test','url','text') or die('create column error');
// $data = array('url'=>'baidu.com');
// MySQLClass::addData($conn,'first_test',array($data,$data)) or die('add data error');
// $data1 =MySQLClass::findData($conn,'first_test','order by id desc limit 1') or die('find data error');
// echo json_encode($data1);
// MySQLClass::close($conn);


$main_params = '{
    "table_name":"haha",
    "description":"This is for Rqyh",
    "main_block":".joke-list-item",
    "start_path":"https://www.haha.mx/",
    "host":"https://www.haha.mx",
    "next_link":{"current":null,"next":null},
    "attribute":{"nick_href":".joke-user-info-nickname","nick":".joke-user-info-nickname"}
}';

$data = Crawler_Data::clawer($main_params);
MySQLClass::addClawerData($main_params,$data);








?>