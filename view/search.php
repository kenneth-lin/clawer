<?php

if(isset($_REQUEST['go_href_set']) && isset($_COOKIE['params']))
{

    $main_params = urldecode($_COOKIE['params']);
    $o_main_params = json_decode($main_params);
    $o_main_params->start_path = $_REQUEST['go_href_set'];
    $o_main_params->main_block = 'body';
    $o_main_params->attribute = json_decode('{
        "title":".title",
        "content":".content"
    }');

    $new_params = json_encode($o_main_params);

    EXT_Template::add_header('./template/show.html');
    EXT_Template::add_header('./template/search.html');


    $data = Crawler_Data::clawer($new_params);
    
    echo ClawerRender::div(ClawerRender::span('Total is '.count($data).'.'));

    $record = new InputDataRecord();
    $render = '';
    $record->init($new_params);
    $attr = $record->attribute;
    foreach( $attr as $key => $value){
        $render = $render.ClawerRender::td_copy(ClawerRender::span($key));
    }
    $render = ClawerRender::tr($render);
    for($i=0;$i<count($data);$i++){
        $temp_render = '';
        foreach( $data[$i] as $key => $value){
            $bContinue = true;
            foreach( $attr as $key_at => $value_at){
                if(strtolower($key) == $key_at) {
                    $bContinue = false;
                    break;
                }
            }

            if($bContinue) continue;
            if(strpos($key,'href') !== false){
                $temp_render = $temp_render.ClawerRender::td(ClawerRender::span(ClawerRender::a($value)));
            }else{
                $temp_render = $temp_render.ClawerRender::td(ClawerRender::span($value));
            }

            
        }
        $temp_render = ClawerRender::tr($temp_render);
        $render = $render.$temp_render;
    }
    echo ClawerRender::table($render);
    return;
}



if(isset($_COOKIE['params']) && isset($_REQUEST['search']) && isset($_REQUEST['column'])){
    $main_params = urldecode($_COOKIE['params']);


    $o_main_params = json_decode($main_params);
    $o_main_params->condition = 'where '.$_REQUEST['column']." like '%".$_REQUEST['search']."%'";
    $new_params = json_encode($o_main_params);


    EXT_Template::add_header('./template/show.html');
    EXT_Template::add_header('./template/search.html');


    $data = MySQLClass::findClawerData($new_params);
    
    echo ClawerRender::div(ClawerRender::span('Total is '.count($data).'.'));

    $record = new InputDataRecord();
    $render = '';
    $record->init($new_params);
    $attr = $record->attribute;
    foreach( $attr as $key => $value){
        $render = $render.ClawerRender::td_copy(ClawerRender::span($key));
    }
    $render = ClawerRender::tr($render);
    for($i=0;$i<count($data);$i++){
        $temp_render = '';
        foreach( $data[$i] as $key => $value){
            $bContinue = true;
            foreach( $attr as $key_at => $value_at){
                if(strtolower($key) == $key_at) {
                    $bContinue = false;
                    break;
                }
            }

            if($bContinue) continue;
            if(strpos($key,'href') !== false){
                $temp_render = $temp_render.ClawerRender::td(ClawerRender::span(ClawerRender::a_go($value)));
            }else{
                $temp_render = $temp_render.ClawerRender::td(ClawerRender::span($value));
            }

            
        }
        $temp_render = ClawerRender::tr($temp_render);
        $render = $render.$temp_render;
    }
    echo ClawerRender::table($render);
    
}else{
    EXT_Template::add_header('./template/show.html');
    EXT_Template::add_header('./template/search.html');
    
}



?>