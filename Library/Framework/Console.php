<?php
namespace System;

class Console
{
    static public function BootMvcm($Path, $Space)
    {
        try
        { 
            /*Load ManagerApplication*/
            \System\CodeManager::Load('/Web/ManagerApplication');
            /*Load base class appplication*/
            $MgrApp = new \System\Web\ManagerApplication();
            /*Create application*/ 
            $MvcmApp = $MgrApp->NewMvcm($Path, $Space);  
            /*Run it and recieve result*/  
            $MvcmApp->Run(new Web\Mvcm\Router($_SERVER['REQUEST_URI']));                   
        } 
        catch (\Exception $Ex)
        {
            new \System\Report\Exception($Ex);
            return FALSE;
        }                    
        /*Success*/ 
        return TRUE;        
    }
}