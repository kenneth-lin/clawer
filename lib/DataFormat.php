<?php

/*

{
    "table_name":"haha",
    "description":"This is for haha.",
    "main_block":".xxx",
    "start_path":"XXX",
    "host":"xxx",
    "next_link":["current":".current","next":".next"],
    "next_link_page": 2,
    "attribute":["title":".hae","img":".ex"]
}


*/
class InputDataRecord
{
    public $crawler_main_table;
    public $crawler_description;
    public $main_block;
    public $next_link;
    public $next_link_page;

    public $attribute;
    public $start_path;
    public $host;


    public function init($json_params)
    {
        $t_var = json_decode($json_params);
        $this->crawler_main_table = $t_var->table_name;
        $this->crawler_description = $t_var->description;
        $this->main_block = $t_var->main_block;
        $this->next_link = $t_var->next_link;
        $this->attribute = $t_var->attribute;
        $this->start_path = $t_var->start_path;
        $this->host = $t_var->host;
        $this->next_link_page = isset($t_var->next_link_page)? $t_var->next_link_page:1;
    }

}


?>
