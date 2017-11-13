<?php

class EXT_Template
{
    static public function add_host($host)
    {
        $string = file_get_contents("./template/host.html");
        $string = str_replace('{{0}}',$host,$string);
        echo $string;
    }

    static public function add_header($header_path)
    {
        $string = file_get_contents($header_path);
        echo $string;
    }

    static function update_host($link, $host)
    {
        if(strpos($link,4,0) == 'http')
        {
            return $link;
        }else if(strpos($link,1,0) != '/'){
            return $host.'/'.$link;
        }else{
            
            return $host.$link;
        }
    }
}


?>