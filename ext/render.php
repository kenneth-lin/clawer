<?php

class ClawerRender{
    static public function table($str)
    {
       return '<table class="show_table"><tbody>'.$str.'</table></tbody>';
    }

    static public function span($str)
    {
       return '<span>'.$str.'</span>';
    }

    static public function td($str)
    {
       return '<td>'.$str.'</td>';
    }

    static public function tr($str)
    {
       return '<tr>'.$str.'</tr>';
    }

    static public function a($str)
    {
       return '<a href="'.$str.'">'.$str.'</a>';
    }

    static public function div($str)
    {
       return '<div>'.$str.'</div>';
    }
}


?>