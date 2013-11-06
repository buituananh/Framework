<?php
namespace Application\Modules\Article\Controllers;

class TypeRead extends \System\Web\Mvcm\Controller
{
    public function Basic()
    {
        if(!isset($_GET['Id']) || empty($_GET['Id']))
        {
            return $this->HttpNotFound();
        }
        $this->ViewBag['Articles'] = $this->GetModel('~/TypeRead')->GetByTypeId($_GET['Id']);
        return $this->View();
    }
}