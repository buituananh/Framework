<?php
namespace Application\Modules\Test\L1\Controllers;

class Index extends \System\Web\Mvcm\Controller
{
    protected $ActionDef = 'Index';
    
    public function Index()
    {       
        
        return $this->View();
    }
}
