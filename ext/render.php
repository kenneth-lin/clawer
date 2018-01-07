<?php

class ClawerRender{
    static public function table($str)
    {
       return '<table class="show_table" id="target_table"><tbody>'.$str.'</tbody></table>';
    }

    static public function span($str)
    {
       return '<span>'.$str.'</span>';
    }

    static public function span_go($str)
    {
       return '<span><a href="/?action=search&column='.$str.'">'.$str.'</a></span>';
    }

    static public function span_update_table($str)
    {
        return '<span onclick="javascript:update_table(\''.$str.'\');">'.$str.'</span>';
    }

    static public function td($str)
    {
       return '<td>'.$str.'</td>';
    }

    static public function td_copy($str)
    {
       return '<td class="td_copy">'.$str.'</td>';
    }

    static public function tr($str)
    {
       return '<tr>'.$str.'</tr>';
    }

    static public function a($str)
    {
       return '<a href="'.$str.'">'.$str.'</a>';
    }

    static public function img($str)
    {
       return '<img src="'.$str.'"></img>';
    }

    static public function a_go($str)
    {
       return '<a onclick="javascript:on_href_click(\''.$str.'\');">'.$str.'</a>';
    }

    static public function div($str)
    {
       return '<div>'.$str.'</div>';
    }
}


?>