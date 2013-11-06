<?php
namespace Application\Modules\Article\Controllers;

class Map extends \System\Web\Mvcm\Controller
{
    public function BasicControl()
    {
        try
        {
            $this->ViewBag['ArticleMap'] = $this->GetModel('~/Map')->GetMap();
            if(!$this->ViewBag['ArticleMap'])
            {
                return $this->HttpNotFound();
            }
            return $this->View();
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Execute error', $Ex);
        }         
    }
}