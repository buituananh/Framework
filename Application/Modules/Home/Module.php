<?php
namespace Application\Modules\Home;

class Module extends \System\Web\Mvcm\Module
{
    protected $ControllerDef = 'Center';
    
    public function OnAuthentication() 
    {
//        \System\Web\Authentication::AllowEveryone();
        \System\Web\Security\Authorization::Authorize();
    }
}