<?php
namespace Application\Modules\Article\Controllers;

class Search extends \System\Web\Mvcm\Controller
{
    public function Json_CurrentUser()
    {
        $Respond['Exception'] = FALSE;
        try
        {
            if(!isset($_POST['Page']) || !isset($_POST['RowPerPage']))
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
                $UserId = $User['Id'];
                $Respond['Articles'] = $this->GetModel('~/ArticleSearch')->SearchByAuthor($UserId, $_POST['Page'], $_POST['RowPerPage']);            
            }
        } 
        catch (\System\Exception $Ex) 
        {
            $Respond['Exception'] = $Ex;
        }
        return $this->Json($Respond);           
    }
}