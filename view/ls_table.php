<?php


    EXT_Template::add_header('./template/show.html');

    $data = MySQLClass::listTable();
    
    echo ClawerRender::div(ClawerRender::span('It shows all the table.'));
    $render = '';
    $attr = json_decode('{"table_name":""}');
    foreach( $attr as $key => $value){
        $render = $render.ClawerRender::td(ClawerRender::span($key));
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



?>