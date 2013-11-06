<?php
namespace Application\Modules\Article\Controllers;

class Editor extends \System\Web\Mvcm\Controller
{
    protected $ActionDef = 'Fully';
    
    public function Fully()
    {
        return $this->View();
    }
}