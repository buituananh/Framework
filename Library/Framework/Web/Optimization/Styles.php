<?php
namespace System\Web\Optimization;

class Styles
{
    static public function Render($Path)
    {
        $Path = $Path.'.css';
        if (!file_exists(\System\Environment::GetRootPath().$Path)) 
        {
            throw new \Exception('Render Cascading Style Sheets fail: '.\System\Environment::GetRootPath().$Path);
        }
        echo '<link rel="stylesheet" type="text/css" href="'.$Path.'" >';      
    }
}