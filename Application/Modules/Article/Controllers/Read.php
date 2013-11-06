<?php
namespace Application\Modules\Article\Controllers;

class Read extends \System\Web\Mvcm\Controller
{
    public function Json_ById()
    {
        $Respond['Exception'] = FALSE;
        try
        {
            if(!isset($_POST['Id']))
            {
                return $this->HttpNotFound('Param invalid');
            }
            $Respond['Article'] = $this->GetModel('~/Article')->Select($_POST['Id']);            
        } 
        catch (\System\Exception $Ex) 
        {
            $Respond['Exception'] = $Ex;
        }
        return $this->Json($Respond); 
    }
    
    public function Single()
    {
        try
        {
            if(!isset($_GET['Id']) || empty($_GET['Id']))
            {
                return $this->HttpNotFound('Param invalid');
            }
            $this->ViewBag['Article'] = $this->GetModel('~/Article')->Select($_GET['Id']);
            if(empty($this->ViewBag['Article']))
            {
                return $this->HttpNotFound('Error');
            }
            $CoverLink = '/Sources/Article/Img/WideCover/'.$this->ViewBag['Article']['Id'].'.png';            
            if(!file_exists(\System\Web\Server::MapRootPath($CoverLink)))
            {
                $CoverLink = '/Sources/Article/Img/Cover/'.$this->ViewBag['Article']['Id'].'.png';
                if(!file_exists(\System\Web\Server::MapRootPath($CoverLink)))
                {
                    $CoverLink = '/Sources/Article/Img/Default/WideArticle.png';
                }                
            }
            $this->ViewBag['Article']['CoverLink'] = $CoverLink;
        } 
        catch (\System\Exception $Ex) 
        {
            return $this->HttpNotFound('Error');
        }        
        return $this->View();
    }
}