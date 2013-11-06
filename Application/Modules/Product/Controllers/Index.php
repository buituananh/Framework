<?php
namespace Application\Modules\Product\Controllers;

class Index extends \System\Web\Mvcm\Controller
{   
    public function Index()
    {
        $Data['Products'] = $this->GetModel('~/ProductSearch')->Pagging(1, 100);
        return $this->View(NULL, $Data);
    }
}