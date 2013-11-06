<?php
namespace System\Web\Mvcm;

class QuitResult extends ActionResult
{
    public function __construct() 
    {
        
    }
    
    public function Execute() 
    {
        exit();
    }
}