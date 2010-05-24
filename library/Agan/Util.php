<?php

class Agan_Util {
   public static function createDir($path, $mode = 0777)
    {
    	$path = str_replace('\\','/',trim($path));
    	if( substr($path,-1) != '/' ) $path = dirname($path);
        if(is_dir($path)) return TRUE;
        $temp = explode( '/' , $path);
        $cur_dir = '';
        $max = count($temp);
        for($i=0; $i<$max; $i++)
        {
            $cur_dir .= $temp[$i]. DIRECTORY_SEPARATOR;
            if(is_dir($cur_dir)) continue;
            if(!@mkdir($cur_dir))
            {
            	echo " $cur_dir <br>";
                return false;
            }
            @chmod($cur_dir, $mode);
        }
        return is_dir($path);
    }
}
