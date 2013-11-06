<?php
namespace Application\Modules\Article\Controllers;

class Insert extends \System\Web\Mvcm\Controller
{
    public function Json_Basic()
    {
        $Respond['Exception'] = FALSE;
        try
        {
            if(!isset($_POST['Name']) || !isset($_POST['Contents']))
            {
                return $this->HttpNotFound('Param invalid');
            }
            $User = \System\Web\Security\User::GetCurrentUser();
            if(!$User)
            {
                $Respond['Exception'] = TRUE;
            }
            else
            {
                $Data = array(
                    'UserId'=>$User['Id'],
                    'Name'=>$_POST['Name'],
                    'Contents'=>$_POST['Contents']
                );
                if(!$this->GetModel('~/Article')->Insert($Data))
                {
                    $Respond['Exception'] = TRUE;
                }                  
            }                   
        } 
        catch (\System\Exception $Ex) 
        {
            $Respond['Exception'] = $Ex;
        }
        return $this->Json($Respond);         
    }
}