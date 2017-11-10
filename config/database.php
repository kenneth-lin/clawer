<?php

define("MYSQL_HOST","localhost");
define("MYSQL_USER","root");
define("MYSQL_PASSWORD","");
define("MYSQL_DATABASE","k_clawer");


function object_array($array) {  
    if(is_object($array)) {  
        $array = (array)$array;  
     } if(is_array($array)) {  
         foreach($array as $key=>$value) {  
             $array[$key] = object_array($value);  
             }  
     }  
     return $array;  
}

class MySQLClass
{
    
    static public function createConn($mysql_database = MYSQL_DATABASE)
    {
        $mysql_server_name=MYSQL_HOST;
        $mysql_username=MYSQL_USER;
        $mysql_password=MYSQL_PASSWORD;
        $conn= new mysqli($mysql_server_name, $mysql_username,$mysql_password,$mysql_database);
        $conn->set_charset("utf8");
        return $conn;
    }
    
    static public function close($conn)
    {
        $conn->close();
    }
    
    static public function createDatabase($database_name = MYSQL_DATABASE)
    {
        $mysql_server_name=MYSQL_HOST;
        $mysql_username=MYSQL_USER;
        $mysql_password=MYSQL_PASSWORD;
        $conn= new mysqli($mysql_server_name, $mysql_username,$mysql_password);
        $datatable=MYSQL_DATABASE;
        $sql = "create database if not exists `$datatable` DEFAULT CHARSET utf8 COLLATE utf8_general_ci;";
        $result = $conn->query($sql);
        if($result === false){
            $conn->close();
            return false;
        }
        $conn->close();
        return true;
    }
    
    static public function createTable($conn,$table_name)
    {
        $sql = "create table if not exists `$table_name`(ID int(11)  NOT NULL auto_increment Primary Key, create_time datetime)";
        $result = $conn->query($sql);
        if($result === false){
            return false;
        }
        return true;
    }
    
    static public function alterTable($conn,$table_name,$column,$type)
    {
        $datatable=MYSQL_DATABASE;
        $sql = "SELECT count(*) as num FROM( "
        . "select COLUMN_NAME from information_schema.COLUMNS "
        . "where TABLE_SCHEMA='$datatable' "
        . "and TABLE_NAME='$table_name' "
        . "and COLUMN_NAME='$column' "
        . ") as B";
        $result = $conn->query($sql);
        if($result === false){
            return false;
        }
        $number_column = 0;
        while($row = $result->fetch_assoc()){
            $number_column = $row['num'];
        }
        
        if($number_column == '0'){
            $sql = "ALTER TABLE `$table_name` ADD $column $type";
        }else{
            $sql = "ALTER TABLE `$table_name` MODIFY $column $type";
        }
        
        $result = $conn->query($sql);
        if($result === false){
            return false;
        }
        return true;
    }
    
    
    static public function addData($conn,$table_name,$data){
        for($i=0;$i<count($data);$i++){
            $temp = $data[$i];
            $column_str = "(";
            $value_str = "(";
            foreach(object_array($temp) as $key => $value)
            {
                $final_value = mysqli_real_escape_string($conn,$value);
                $column_str = $column_str.$key.",";
                $value_str = $value_str."'$final_value'".",";
            }
            //$column_str = substr($column_str,0,strlen($column_str)-1);
            //$value_str = substr($value_str,0,strlen($value_str)-1);
            $column_str .= "create_time)";
            $value_str .= "now())";
            
            $sql = "insert into `$table_name`".$column_str." value".$value_str;
            $result = $conn->query($sql);
            if($result === false){
                return false;
            }
        }
        return true;
    }
    
    static public function findData($conn,$table_name,$condition){
        $sql = "select * from `$table_name` ".$condition;
        $result = $conn->query($sql);
        $reslist = array();
        while($row = $result->fetch_assoc()){
            $reslist[] = $row;
        }
        return $reslist;
    }

    static public function clawerInit($json_params)
    {
        $record = new InputDataRecord();
        $record->init($json_params);

        MySQLClass::createDatabase() or die('create database error');
        $conn = MySQLClass::createConn();
        MySQLClass::createTable($conn,$record->crawler_main_table) or die('create table error');
        foreach($record->attribute as $key => $value)
        {
            MySQLClass::alterTable($conn,$record->crawler_main_table,$key,'text') or die('create column error');
        }
        //$conn->close();
        return $conn;
    }

    static public function addClawerData($json_params,$data)
    {

        $conn = MySQLClass::clawerInit($json_params);
        $record = new InputDataRecord();
        $record->init($json_params);
        MySQLClass::addData($conn,$record->crawler_main_table,$data);
        MySQLClass::close($conn);
    }

    static public function findClawerData($json_params){
        $conn = MySQLClass::createConn();
        $record = new InputDataRecord();
        $record->init($json_params);
        $data = MySQLClass::findData($conn,$record->crawler_main_table,$record->condition);
        MySQLClass::close($conn);
        return $data;
    }
    
}


?>