<?php
namespace Application\Modules\User\Controllers;

class Login extends \System\Web\Mvcm\Controller
{
    public function Control()
    {
        return $this->View();
    }
    
    public function Json_ByUserName()
    {
        $Respond['Result'] = TRUE;
        try
        {
            $Respond['Logged'] = TRUE;
            if(!$this->GetModel('~/Login')->ByUserName($_POST['UserName'], $_POST['Password']))
            {
                $Respond['Logged'] = FALSE;
            }
        } 
        catch (\System\Exception $Ex) 
        {
            $Respond['Result'] = FALSE;
            $Respond['Exception'] = $Ex;
        }
        return $this->Json($Respond);
    }
}