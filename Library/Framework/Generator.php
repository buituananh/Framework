<?php
namespace System;

class Generator extends \System\Object
{
    static public function NewObject($Path, $Type)
    {
        /*Path extension .php*/ 
        $PathFile = $Path.'.php'; 
        /*Check file exist contain class*/
        if (!file_exists($PathFile)) 
        {
            throw new \System\Exception('File is not exist: '.$PathFile);
        }
        /*Loat file*/
        try 
        {
            include_once $PathFile;
        } 
        catch (Exception $Ex) 
        {
            throw new \System\Exception('Error during load file: '.$PathFile, $Ex);
        }       
        /*Check class exist*/ 
        if (!class_exists($Type)) 
        {
            throw new \System\Exception('Class is not exist: '.$Type);        
        }
        return new $Type();
    }
}
