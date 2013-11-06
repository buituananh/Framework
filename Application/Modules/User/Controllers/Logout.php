<?php
namespace Application\Modules\User\Controllers;

class Logout extends \System\Web\Mvcm\Controller
{   
    public function Json_Basic()
    {
        $Respond['Result'] = TRUE;
        try
        {
            $Respond['Offline'] = TRUE;
            if(!$this->GetModel('~/Logout')->Basic())
            {
                $Respond['Offline'] = FALSE;
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