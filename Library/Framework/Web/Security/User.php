<?php
namespace System\Web\Security;

class User
{
    protected static $CurrentUser;
    protected static $ConnectionAttr = array();
    protected static $UserTableName;
    protected static $UserIdColumn;
    protected static $UserNameColumn;
    protected static $AutoCreate;
    protected static $Connection;

    const UserAuthTableName = 'sys_users_auth';
    const UserLoginTableName = 'sys_users_login';
    const UserInvokeLoginTableName = 'sys_users_invokelogin';
    const UserSessionId = 'sys_user_id';
    const UserSessionName = 'sys_user_name';
    const UserCookieId = 'sys_user_id';
    const UserCookieName = 'sys_user_name';
    const UserCookieAuth = 'sys_user_auth';

    public static function SetDatabase($ConnectionAttr, $UserTableName, $UserIdColumn, $UserNameColumn, $AutoCreate = FALSE)
    {
        self::$ConnectionAttr = $ConnectionAttr;
        self::$UserTableName = $UserTableName;
        self::$UserIdColumn = $UserIdColumn;
        self::$UserNameColumn = $UserNameColumn;
        self::$AutoCreate = $AutoCreate;
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
    
    public static function Login($UserName, $Password)
    {
        try 
        {
            /*Check user is valid*/
            $Query = "SELECT Id FROM ".self::UserAuthTableName." WHERE UserName = '$UserName' AND Password = '$Password'";
            $SrcResult = self::GetConnection()->query($Query);
            if(!$SrcResult || $SrcResult->num_rows != 1) 
            {
                return FALSE;
            }
            /*Set database*/
            $Ip = $_SERVER['REMOTE_ADDR'];
            $UserAgent = $_SERVER['HTTP_USER_AGENT'];
            $UserId = $SrcResult->fetch_assoc();
            $UserId = $UserId['Id'];
            $Cer = rand(65535, 999999);
            $Query = "INSERT INTO ".self::UserLoginTableName." (Ip, UserAgent, UserId, Cer) VALUES ('$Ip', '$UserAgent', '$UserId', '$Cer')";
            self::GetConnection()->query($Query);
            /*Set session*/
            $_SESSION[self::UserSessionId] = $UserId;
            $_SESSION[self::UserSessionName] = $UserName;
            /*Set cookie*/  
            setcookie(self::UserCookieId, $UserId, time()+3600, '/');
            setcookie(self::UserCookieName, $UserName, time()+3600, '/');
            setcookie(self::UserCookieAuth, $Cer, time()+3600, '/');
            /*Complete*/ 
            return TRUE;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Login error', $Ex);
        }
            
    }
    
    public static function Logout()
    {
        try
        {
            $User = self::GetCurrentUser();            
            if($User)
            {
                $Ip = $_SERVER['REMOTE_ADDR'];
                $UserAgent = $_SERVER['HTTP_USER_AGENT'];
                $UserId = $User['Id'];
                /*Unset database*/ 
                $Query = "DELETE FROM ".self::UserLoginTableName." WHERE Ip = '$Ip' AND UserAgent = '$UserAgent' AND UserId = '$UserId'";
                self::GetConnection()->query($Query);
                /*Unet session*/
                unset($_SESSION[self::UserSessionId]);
                unset($_SESSION[self::UserSessionName]);
                /*Unset cookie*/  
                setcookie(self::UserCookieId, '', time()-3600, '/');
                setcookie(self::UserCookieName, '', time()-3600, '/');
                setcookie(self::UserCookieAuth, '', time()-3600, '/');
                /*Complete*/
                return TRUE;
            }
            return FALSE;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Error during logout', $Ex);
        }
    }
    
    public static function InsertUser($UserName, $Password)
    {
        
    }
    
    public static function ChangePassword($Id, $NewPassword)
    {
        
    }
    
    public static function GetCurrentUser()
    {
        try
        {            
            $Ip = $_SERVER['REMOTE_ADDR'];
            $UserAgent = $_SERVER['HTTP_USER_AGENT'];
            if(!isset($_SESSION[self::UserSessionId]))
            { 
                return FALSE;
            }
            else
            {
                $UserId = $_SESSION[self::UserSessionId];
            }
            if(!isset($_COOKIE[self::UserCookieAuth]))
            {  
                return FALSE;
            }
            else
            {
                $Cer = $_COOKIE[self::UserCookieAuth]; 
            }            
            $Query = "SELECT Ip FROM ".self::UserLoginTableName." WHERE Ip = '$Ip' AND UserAgent = '$UserAgent' AND UserId = '$UserId' AND Cer = '$Cer'";
            $SrcResult = self::GetConnection()->query($Query);
            if(!$SrcResult || $SrcResult->num_rows != 1)
            { 
                return FALSE;
            }
            $User['Id'] = $UserId;
            $User['UserName'] = self::GetUserNameById($UserId);
            return $User;            
        } 
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Error during check login', $Ex);
        }        
    }
    
    public static function GetUserNameById($UserId)
    {
        $Query = "SELECT UserName FROM ".self::UserAuthTableName." WHERE Id = '$UserId'";
        $SrcResult = self::GetConnection()->query($Query);
        $ArrResult = $SrcResult->fetch_assoc();
        if(empty($ArrResult))
        {
            return FALSE;
        }
        return $ArrResult['UserName'];
    }
}