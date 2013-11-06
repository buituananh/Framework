<?php
namespace Application\Modules\User\Models;

class Login extends \System\Web\Mvcm\Model
{
    public function ByUserName($UserName, $Password)
    {
        return \System\Web\Security\User::Login($UserName, $Password);
    }
}