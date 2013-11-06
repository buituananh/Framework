<?php
namespace System;

class About
{
    const Name = 'Unix framework';
    protected static $Version;    
    protected static $DirPath;
    protected static $Inited = FALSE;

    public static function Init() 
    {
        if (self::$Inited) 
        {
            return;
        }
        self::$Version = new Version(5, 0, 0, 0, '08/01/2012', '10/05/2013');
        self::$DirPath = __DIR__;
        self::$Inited = TRUE;
    }
    
    public static function GetVersion()
    {
        return self::$Version;
    }
    
    public static function GetDirPath()
    {
        return self::$DirPath;
    }
}