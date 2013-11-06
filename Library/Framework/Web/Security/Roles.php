<?php
namespace System\Web\Security;

class Roles
{    
    protected static $ConnectionAttr = array();
    protected static $Connection;
    
    protected static $RolesTable = 'sys_users_roles';
    protected static $UsersInRolesTable = 'sys_users_inroles';

    public static function SetDatabase($ConnectionAttr)
    {
        self::$ConnectionAttr = $ConnectionAttr;
    }
    
    public static function Dispose()
    {
        if(self::$Connection)
        {
            self::$Connection->Close();
        }
    }
    
    protected static function GetConnection()
    {
        if(!self::$Connection)
        {
            self::$Connection = mysqli_connect(self::$ConnectionAttr['Server'], self::$ConnectionAttr['User'], self::$ConnectionAttr['Password'], self::$ConnectionAttr['Database']);
        }
        return self::$Connection;
    }

    public static function  AddUserIdsToRoleIds($UserIds = array(), $RoleIds = array())
    {
        try
        {
            $Query = "";
            foreach ($UserIds as $UserId) 
            {
                foreach ($RoleIds as $RoleId) 
                {
                    $Query = $Query."INSERT INTO ".self::$UsersInRolesTable." "
                            . "(UserId, RoleId) "
                            . "VALUES ($UserId, $RoleId);";                     
                }                  
            }         
            $SrcResult = self::GetConnection()->multi_query($Query);            
            if(!$SrcResult)
            {
                return FALSE;
            }
            return TRUE;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Add users to role error', $Ex);
        }
                  
    }

    public static function  CreateRoles($RoleNames)
    {
        try
        {
            $Query = "";
            foreach ($RoleNames as $RoleName) 
            {
                $Query = $Query."INSERT INTO ".self::$RolesTable." "
                        . "(Name) "
                        . "VALUES ('$RoleName');";                               
            }         
            $SrcResult = self::GetConnection()->multi_query($Query);  
            if(!$SrcResult)
            {
                return FALSE;
            }
            return TRUE;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Create role error', $Ex);
        }        
    }

    public static function  DeleteRoleIds($RoleIds)
    {
        try
        {
            $Query = "";
            foreach ($RoleIds as $RoleId) 
            {
                $Query = $Query."DELETE FROM ".self::$RolesTable." "
                        ."WHERE Id = '$RoleId';";                              
            }         
            $SrcResult = self::GetConnection()->multi_query($Query);  
            if(!$SrcResult)
            {
                return FALSE;
            }
            return TRUE;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Delete role error', $Ex);
        }        
    }

    public static function  FindUserIdsInRoleIds($RoleIds)
    {
        try
        {
            $Query = "SELECT UserId FROM ".self::$UsersInRolesTable." WHERE ";
            $Flag = TRUE;
            foreach ($RoleIds as $RoleId) 
            {
                if(!$Flag)
                {
                    $Query = $Query."OR";
                }
                else
                {
                    $Flag = FALSE;
                }
                $Query = $Query." RoleId = '$RoleId'";                                          
            }         
            $SrcResult = self::GetConnection()->multi_query($Query);  
            echo $Query;
            var_dump(self::GetConnection()->error);
            if(!$SrcResult)
            {
                return FALSE;
            }
            return TRUE;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Find user id error', $Ex);
        }           
    }

    public static function  GetAllRoles()
    {
        
    }

    public static function  GetRolesForUserId($UserId)
    {
        try
        {
            $Roles = array();
            $Query = "SELECT Name FROM ".self::$UsersInRolesTable." "
                    . "INNER JOIN ".self::$RolesTable." ON ".self::$UsersInRolesTable.".RoleId = ".self::$RolesTable.".Id "
                    . "WHERE ".self::$UsersInRolesTable.".UserId = ".$UserId;            
            $SrcResult = self::GetConnection()->query($Query);
            if($SrcResult)
            {
                while ($Row = $SrcResult->fetch_assoc())
                {
                    array_push($Roles, $Row['Name']);
                }
            }
            return $Roles;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Get roles for user id error', $Ex);
        }
    }

    public static function  GetUsersInRole($RoleName)
    {
    }
    
    public static function  IsUserInRole($Username, $RoleName)
    {
        
    }

    public static function  RemoveUserFromRole($Username, $RoleName)
    {
    }

    public static function  RemoveUserFromRoles($Username, $RoleNames)
    {
    }

    public static function  RemoveUsersFromRole($UserName, $RoleName)
    {
    }

    public static function  RemoveUsersFromRoles($UserName, $RoleNames)
    {
    }

    public static function  RoleExists($RoleName)
    {
    }    
}