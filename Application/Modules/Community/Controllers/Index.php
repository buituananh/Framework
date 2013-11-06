<?php
namespace Application\Modules\Community\Controllers;

class Index extends \System\Web\Mvcm\Controller
{
    public function Index()
    {
        $Data['Communitys'] = $this->GetModel('~/CommunitySearch')->GetAll();
        return $this->View(NULL, $Data);
    }
}
