<?php
namespace Application\Modules\Article\Controllers;

class Delete extends \System\Web\Mvcm\Controller
{
    public function Json_Basic()
    {
        $Respond['Result'] = TRUE;
        try
        {
            if(!isset($_POST['Id']))
            {
                return $this->HttpNotFound('Param invalid');
            }
            if(!$this->GetModel('~/Article')->Delete($_POST['Id']))
            {
                $Respond['Result'] = FALSE;
            }                     
        } 
        catch (\System\Exception $Ex) 
        {
            $Respond['Result'] = $Ex;
        }
        return $this->Json($Respond);            
    }
}