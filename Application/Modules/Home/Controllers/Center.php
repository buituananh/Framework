<?php
namespace Application\Modules\Home\Controllers;

class Center extends \System\Web\Mvcm\Controller
{
    protected $ActionDef = 'Classic';
    
    public function OnAuthorization($FilterContext = NULL) 
    {
//        \System\Web\Authentication::Authorize(array('Root', 'Admin'));
        \System\Web\Security\Authorization::AllowEveryone();
    }

    public function Classic()
    {
//        \System\Web\Authentication::AllowEveryone();
        \System\Web\Security\Roles::FindUserIdsInRoleIds(array(5));
        return $this->View();
    }
}