<?php
namespace System;

class CodeManager
{
    const STARTING = 0;
    const MATHING = 1;
    const ENDING = 2;
    const M_NAMESPACE = 3;
    const M_CLASS = 4;
    const M_NONE = 5;
    static public function Load($Path)
    {
        /*Real path to file*/
        $PathFile = dirname(__FILE__).$Path.'.php';        
        /*Check file exist before include*/
        if (!file_exists($PathFile)) 
        {
            throw new \Exception('File is not exist: '.$PathFile);
        }
        /*File exist, include_once it*/
        try
        {
            include_once $PathFile;         
        }
        catch (\Exception $Ex)
        {
            throw new \Exception('Error during load file: '.$PathFile, $Ex);
        }    
        /*Path to class contain '/'*/ 
        $Type = '\System'.$Path;
        /*Fix Path by replace '/' to '\'*/
        $Type = str_replace('/', '\\', $Type);
        /*Check class exist*/
        if (!class_exists($Type)) 
        {
            throw new Exception('Class '.$Type.' is not exist');          
        }
    }
    
    static public function LoadInterface($Path)
    {
        /*Real path to file*/
        $PathFile = dirname(__FILE__).$Path.'.php';        
        /*Check file exist before include*/
        if (!file_exists($PathFile)) 
        {
            throw new \Exception('File is not exist: '.$PathFile);
        }
        /*File exist, include_once it*/
        try
        {
            include_once $PathFile;         
        }
        catch (\Exception $Ex)
        {
            throw new \Exception('Error during load file: '.$PathFile, $Ex);
        }    
        /*Path to class contain '/'*/ 
        $Type = '\System'.$Path;
        /*Fix Path by replace '/' to '\'*/
        $Type = str_replace('/', '\\', $Type);
        /*Check class exist*/
        if (!interface_exists($Type)) 
        {
            throw new Exception('Class '.$Type.' is not exist');          
       
        }
    }
    
    static public function LoadSpace($Path)
    { 
        try
        {
            $RealPath = \System\Environment::GetSystemPath().$Path; 
            $ListFile = scandir($RealPath);
            foreach ($ListFile as $value) 
            { 
                if ($value == '.' || $value == '..')                
                {
                    continue;
                }        
                if(pathinfo($value, PATHINFO_EXTENSION) == 'php')
                {
                    include_once $RealPath.'/'.$value;        
                }
            }
            foreach ($ListFile as $value) 
            {
                if ($value == '.' || $value == '..')                
                {
                    continue;
                }  
                if (is_dir($RealPath.'/'.$value)) 
                {       
                    self::LoadSpace(str_replace('\\\\', '\\', $Path.'/'.$value.'/'));                     
                }
            }             
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Load space failer', $Ex);
        }
    }
    
    static protected $Lv;
    static public function ViewSpace($Path)
    {
        self::$Lv++;
        $RealPath = \System\Environment::GetSystemPath().$Path;
        $ListFile = scandir($RealPath, SCANDIR_SORT_NONE);
        if (!is_array($ListFile))
        {
            return;
        }
        for ($index = 1; $index <= self::$Lv; $index++) {
            echo '#';
        }
        echo '<span style="color:red">'.pathinfo($Path, PATHINFO_BASENAME).'<br></span>';
        foreach ($ListFile as $value) 
        {
            if ($value == '.' || $value == '..')                
            {
                continue;
            }  
            if(pathinfo($value, PATHINFO_EXTENSION) == 'php')      
            {
                for ($index = 1; $index <= self::$Lv; $index++) {
                    echo '-';
                }                
                echo '<span style="color:orange">'.$value.'</span> <span style="color:green">'.  str_replace('//', '/', $RealPath.$value).'</span>';        
                $Class = 'System'.$Path.pathinfo($value, PATHINFO_FILENAME);
                $Class = str_replace('/', '\\', $Class);
                $Class = str_replace('\\\\', '\\', $Class);
                $Code = \System\CodeManager::GetClassFromFile($RealPath.$value);
                foreach ($Code as $key => $value) 
                {
                    if($Class == $key.'\\'.$value[0])
                    {
                        echo '-OK'; 
                    }
                    else
                    {
                        echo '-ERROR';
                        
                    }                    
                }
                echo '<br>';
            }
        }    
        foreach ($ListFile as $value) 
        {
            if ($value == '.' || $value == '..')                
            {
                continue;
            }  
            if (is_dir($RealPath.'/'.$value)) 
            {       
                self::ViewSpace(str_replace('\\\\', '\\', $Path.'/'.$value.'/'));                     
            }
        }         
        self::$Lv--;
    }
    
    public static function GetClassFromFile($Path)
    {
        $nc = array();
        $tokens = token_get_all( file_get_contents($Path) );        
//        var_dump($tokens)  ;
        $namespace_token = self::STARTING;
        $class_token = self::STARTING;
        $math = self::M_NONE;
        $namespace = '';
        $class = '';
        foreach ($tokens as $token) 
        {            
            switch ($math)
            {
                case self::M_NAMESPACE:
                    switch ($namespace_token) 
                    {
                        case self::STARTING:
                            if(is_array($token))
                            {
                                switch ($token[0]) {
                                    case T_WHITESPACE:
                                        continue;                                        
                                    case T_STRING || T_NS_SEPARATOR:                                        
                                        $namespace = $namespace.$token[1];
                                        $namespace_token = self::MATHING;
                                        continue;
                                    default:
                                        break;
                                }
                            }
                            else
                            {
                                return;
                            }                            
                            break;
                        case self::MATHING:
                            if(is_array($token))
                            {
                                if($token[0] == T_STRING || $token[0] == T_NS_SEPARATOR)
                                {
                                    $namespace = $namespace.$token[1];
                                }
                                else
                                {
                                    $namespace_token  = self::ENDING;                                    
                                }
                            }  
                            else
                            {
                                $namespace_token  = self::ENDING;                   
                            }
                            break;
                        case self::ENDING:
                            $nc[$namespace] = array();                            
                            $math = self::M_NONE;
                            continue;                        
                        default:
                            break;
                    }
                    break;
                case self::M_CLASS:
                    switch ($class_token) 
                    {
                        case self::STARTING:
                            if(is_array($token))
                            {
                                switch ($token[0]) {
                                    case T_WHITESPACE:
                                        continue;                                        
                                    case T_STRING || T_NS_SEPARATOR:                                        
                                        $class = $class.$token[1];
                                        $class_token = self::MATHING;
                                        continue;
                                    default:
                                        break;
                                }
                            }
                            else
                            {
                                return;
                            }
                            break;
                        case self::MATHING:
                            if(is_array($token))
                            {
                                if($token[0] == T_STRING || $token[0] == T_NS_SEPARATOR)
                                {
                                    $class = $class.$token[1];
                                }   
                            }
                            $class_token  = self::ENDING;              
                            break;
                        case self::ENDING:  
                            $math = self::M_NONE;
                            array_push($nc[$namespace], $class);
                            continue;
                        default:
                            break;
                    }
                    break;
                case self::M_NONE:
                    if(is_array($token))
                    {
                        switch ($token[0]) 
                        {
                            case T_NAMESPACE:
                                $math = self::M_NAMESPACE;
                                $namespace_token = self::STARTING;
                                $namespace = '';
                                break;
                            case T_CLASS:
                                $math = self::M_CLASS;
                                $class_token = self::STARTING;
                                $class = '';
                                break;
                            default:
                                break;
                        }
                    }
                    continue;                
                default:
                    return;
            }
        }     
        return $nc;
    }
    
    public static function StandardizedFile($Path)
    {
        $RealPath = \System\Environment::GetSystemPath().$Path;
        $ListFile = scandir($RealPath, SCANDIR_SORT_NONE);
        if (!is_array($ListFile))
        {
            return;
        }
        foreach ($ListFile as $value) 
        {
            if ($value == '.' || $value == '..')                
            {
                continue;
            }  
            if(pathinfo($value, PATHINFO_EXTENSION) == 'php')      
            {      
                $OldePath = $RealPath.$value;                
                $name = pathinfo($value, PATHINFO_FILENAME);                
                $NewPath = $RealPath.trim(pathinfo($name, PATHINFO_FILENAME)).'.'.pathinfo($value, PATHINFO_EXTENSION);
                if($name[strlen($name) - 1] == ' ')
                {
                    if(rename($OldePath, $NewPath))
                    {
                        echo 'OK';
                    }
                    else
                    {
                        echo 'FAIL';                        
                    }
                    echo '<br>';
                }                
            }
        }     
        foreach ($ListFile as $value) 
        {
            if ($value == '.' || $value == '..')                
            {
                continue;
            }  
            if (is_dir($RealPath.'/'.$value)) 
            {       
                self::StandardizedFile(str_replace('//', '/', $Path.'/'.$value.'/'));                     
            }
        }          
    }
}