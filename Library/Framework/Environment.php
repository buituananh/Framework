<?php
namespace System;

class Environment
{
    static private $SourcesPath = '';   
    static private $RootPath = '';
    static private $ServerPath = '';
    static private $SystemPath = '';

    static public function InitSystem($ServerPath, $SourcesPath = NULL)
    {
        /*Define path constant to System directory*/                 
        self::$SystemPath = __DIR__;
        /*Define path constant to Root direcory*/
        self::$ServerPath = $ServerPath;
        /**/
        self::$RootPath = $_SERVER['DOCUMENT_ROOT'];
        self::$SourcesPath = $SourcesPath;
        include_once __DIR__.'/CodeManager.php';
        try
        {                        
            \System\CodeManager::Load('/Exception');
            \System\CodeManager::Load('/Report/Exception');
            \System\CodeManager::Load('/Console');
            \System\CodeManager::Load('/Object');
            \System\CodeManager::Load('/Generator');
            \System\CodeManager::Load('/Version');
            \System\CodeManager::Load('/About');
            \System\CodeManager::Load('/About');
            \System\CodeManager::LoadInterface('/IDisposable');
            
            \System\CodeManager::Load('/Web/Server');
            \System\CodeManager::Load('/Web/HttpRequest');      
            \System\CodeManager::Load('/Web/HttpRespond'); 
            \System\CodeManager::Load('/Web/Security/User');             
            
            \System\CodeManager::Load('/IO/Stream');
            \System\CodeManager::Load('/IO/File');
            \System\CodeManager::Load('/IO/FileInfo');   
            \System\CodeManager::Load('/IO/FileStream');
                                   
            
            About::Init();
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Error during load base class', $Ex);
        }        
    }
    
    public static function GetSourcesPath()
    {
        return self::$SourcesPath;
    }
    
    public static function GetServerPath()
    {
        return self::$ServerPath;
    }
    
    public static function GetRootPath()
    {
        return self::$RootPath;
    }
    
    public static function GetSystemPath()
    {
        return self::$SystemPath;
    }  
}

