<?php
namespace Application\Modules\User\Controllers;

class Info extends \System\Web\Mvcm\Controller
{    
    public function Json_GetAvatarLinkByUserName()
    {
        $Respond['Result'] = TRUE;
        try
        {
            if(!isset($_POST['UserName']))
            {
                $Respond['Result'] = FALSE;
            }
            else
            {
                $Respond['Path'] = $this->GetModel('~/Info')->GetAvatarLinkByUserName($_POST['UserName']);
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