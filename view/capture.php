<?php

if(isset($_REQUEST['params'])){
    $main_params = $_REQUEST['params'];
    EXT_Template::add_header('./template/show.html');
    EXT_Template::add_header('./template/auto_refresh.html');

    $data = Crawler_Data::clawer($main_params);

    echo ClawerRender::div(ClawerRender::span('Total is '.count($data).'.'));
    
        $record = new InputDataRecord();
        $render = '';
        $record->init($main_params);
        $attr = $record->attribute;
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


        if(isset($_REQUEST['refresh']) && $_REQUEST['refresh'] == 1 ){
            echo '<script>refresh_click();</script>';
        }
}else{
    echo 'Click "Submit" to capture.';
}



?>