<?php
namespace Application\Modules\Article\Controllers;

class Update extends \System\Web\Mvcm\Controller
{
    public function Json_ById()
    {
        $Respond['Exception'] = FALSE;
        try
        {
            if(!isset($_POST['Id']) || !isset($_POST['Name']) || !isset($_POST['Contents']))
            {
                return $this->HttpNotFound('Param invalid');
            }
            $Data = array(
                'Name'=>$_POST['Name'],
                'Contents'=>$_POST['Contents']
            );
            if(!$this->GetModel('~/Article')->Update($_POST['Id'], $Data))
            {
                $Respond['Exception'] = TRUE;
            }                     
        } 
        catch (\System\Exception $Ex) 
        {
            $Respond['Exception'] = $Ex;
        }
        return $this->Json($Respond);         
    }
}
