<?php
namespace System\Web\Security;

class Authorization
{    
    protected static $Authorize = TRUE;

    public static function Authorize($RolesName = array())
    {        
        $User = User::GetCurrentUser();        var_dump($User);
        if(!$User)
        { 
            self::$Authorize = FALSE;
            return;
        }
        else
        {
            self::$Authorize = TRUE;
        } 
        if(empty($RolesName))
        {
            return;
        } 
        $UserRoles = Security\Roles::GetRolesForUserId($User['Id']);  
        self::$Authorize = FALSE;
        foreach ($RolesName as $Name)
        {
            if(in_array($Name, $UserRoles))
            {
                self::$Authorize = TRUE;
                break;
            }
        }        
    }
    
    public static function AllowEveryone()
    {
        self::$Authorize = TRUE;   
    }
    
    public static function IsValid()
    { 
        return self::$Authorize;
    }
}