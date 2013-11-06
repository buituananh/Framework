<?php
namespace System\Web;

class HtmlTag
{
    static function FindTag(&$Content, $Tag1)
    {
        $Found = array();
        preg_match_all($Tag1, $Content, $Found);
        $Tag = array();
        foreach ($Found[0] as $value) 
        {
            $split = str_getcsv($value, ' ');
            array_shift($split);
            unset($split[count($split) - 1]);
            $elem = array();
            foreach ($split as $value2) 
            {
                $split2 = str_getcsv($value2, '='); 
                $elem[$split2[0]] = $split2[1];
            }
            array_push($Tag, $elem);
            
        }
        $Content = preg_replace($Tag1, '', $Content);
        return $Tag;
    }
}
