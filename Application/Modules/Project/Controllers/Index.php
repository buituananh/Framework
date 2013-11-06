<?php
namespace Application\Modules\Project\Controllers;

class Index extends \System\Web\Mvcm\Controller
{   
    public function Index()
    {
        $Data['Best'] = $this->GetModel('~/ProjectTask')->GetBest();
        return $this->View(NULL, $Data);
    }
}