<?php

class Crawler_Data
{
    
    public $_crawler_from = '';
    public $_host = '';
    private $_out_data = array();
    public $_crawler_params;
    public $_special_encode;
    
    static public function clawer($params)
    {
        $data = array();
        try{
            $crawler = new Crawler_Data();
            $crawler->init($params);
            $pars = $crawler->params();
            $crawler->get_count_run_dom($pars->next_link_page,false);
            $data = $crawler->get_out_data();
        }catch(Exception $e){
            
        }
        return $data;
    }

    static public function updateClawerParamLink($params,$link){
        $t_var = json_decode($main_params);
        if(strpos($link,4,0) == 'http')
        {
            $t_var->start_path = $link;
        }else{
            $t_var->start_path = $t_var->host.$link;
        }
        return json_encode($t_var);
    }
    
    
    public function init($json_params)
    {
        $record = new InputDataRecord();
        $record->init($json_params);
        $this->_crawler_params = $record;
        $this->_crawler_from = $this->_crawler_params->start_path;
        $this->_host = $this->_crawler_params->host;
        $this->_out_data = array();
        $this->_special_encode = $record->encode;
    }

    public function params()
    {
        return $this->_crawler_params;
    }
    
    public function get_out_data()
    {
        return $this->_out_data;
    }
    
    public function get_count_run_dom($count,$print = false)
    {
        $params = $this->_crawler_params;
        $run_path = $this->_crawler_from;
        for($i=0;$i<$count;$i++)
        {
            if(!empty($run_path)){
                $run_path = $this->get_dom_data($run_path,$params->main_block,$params->attribute,$this->_out_data,$params->next_link,$print);
            }
        }
    }
    
    function get_dom_data($path,$data_attribute,$array_data_need,&$out_data,$next_path_attribute,$print = false)
    {
        
        $html = new simple_html_dom();
        $cnt=0;
        
        $content_parm = stream_context_create(array(
        'http' => array(
        'timeout' => 5
        )
        ));
        while($cnt < 3 && ($str=@$html->load_file($path))===FALSE) {
            $cnt++;
        }
        if($cnt == 3) return;
        foreach($html->find($data_attribute) as $data_list){
            if(empty($data_list)) continue;
            if($print) print_r($data_list->outertext);
            $temp = array();
            foreach($array_data_need as $key => $attribute){
                if(empty($attribute)) {
                    $e = $data_list;
                }else{
                    $e = $data_list->find($attribute, 0);
                }
                if(empty($e)){
                    $temp[$key] = '';
                }else{
                    if(strpos($key,'href') !== false){
                        //$temp[$key] = $this->update_host($e->href,$this->_host);
                        $target = $e->href;
                        if(empty($target))
                        {
                            $target = $e->find('a',0)->href;
                            $temp[$key] = $this->update_host($target, $this->_host);
                        }else{
                            $temp[$key] = $this->update_host($target, $this->_host);
                        }
                    }else{
                        if(empty($e->innertext)){
                            $temp[$key] = '';
                        }else{
                            if(empty($this->_special_encode)){
                                $temp[$key] = mb_convert_encoding($e->innertext,'UTF-8');
                            }else{
                                $temp[$key] = mb_convert_encoding($e->innertext,'UTF-8',$this->_special_encode);
                            }
                        }
                    }
                }
            }
            array_push($out_data,$temp);
        }
        return $this->find_next_path($html,$next_path_attribute);
    }
    
    function find_next_path($html,$next_path_attribute)
    {
        if($next_path_attribute->next == null) return '';
        if($next_path_attribute->current == null)
        { 
            return $this->update_host($html->find($next_path_attribute->next,0)->href, $this->_host);
        }else
        {
            $e = $html->find($next_path_attribute->current,0);
            $p = $e->next_sibling();
            $target = $p->href;
            if(empty($target))
            {
                $target = $p->find('a',0)->href;
                return $this->update_host($target, $this->_host);
            }else{
                return $this->update_host($target, $this->_host);
            }
            
            
        }
    }
    
    function update_host($link, $host)
    { 
        if(strpos($link,'http',0) === 0)
        {
            return $link;
        }else if(strpos($link,'/',0) === 0){
            return $host.$link;
        }else{
            return $host.'/'.$link;
        }
    }
    
}

?>