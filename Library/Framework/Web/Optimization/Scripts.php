<?php
namespace System\Web\Optimization;

class Scripts
{
    static public function Render($Path)
    {
        $Path = $Path.'.js';
        if (!file_exists(\System\Environment::GetRootPath().$Path)) 
        {
            throw new \Exception('Render JavaScript fail: '.\System\Environment::GetRootPath().$Path);        
        }
        echo '<script src="'.$Path.'"></script>';         
    }
}