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
}


?>