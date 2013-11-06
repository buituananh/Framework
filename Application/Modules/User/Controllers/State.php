<?php
namespace Application\Modules\User\Controllers;

class State extends \System\Web\Mvcm\Controller
{   
    public function Json_Check()
    {
        $Respond['Result'] = TRUE;
        try
        {
            $Respond['Logging'] = TRUE;
            $User = $this->GetModel('~/State')->Check();            
            if(!$User)
            {
                $Respond['Logging'] = FALSE;
            }
            else
            {
                $Respond['User'] = $User;
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