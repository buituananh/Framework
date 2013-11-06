<?php
namespace Application\Modules\Article;

class Module extends \System\Web\Mvcm\Module
{
    public function OnAuthenticatio()
    {
        \System\Web\Security\Authorization::Authorize();
    }
}