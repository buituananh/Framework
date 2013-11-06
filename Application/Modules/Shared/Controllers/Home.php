<?php
namespace Application\Modules\Shared\Controllers;

class Home extends \System\Web\Mvcm\Controller
{
    public function Classic()
    {
        return $this->View();
    }
}