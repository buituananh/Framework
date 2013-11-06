<?php
namespace Application\Modules\User\Models;

class Logout extends \System\Web\Mvcm\Model
{
    public function Basic()
    {
        return \System\Web\Security\User::Logout();
    }
}