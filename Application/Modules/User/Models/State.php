<?php
namespace Application\Modules\User\Models;

class State extends \System\Web\Mvcm\Model
{
    public function Check()
    {
        return \System\Web\Security\User::GetCurrentUser();
    }
}