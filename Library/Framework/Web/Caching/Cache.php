<?php
namespace System\Web\Caching;

class Cache extends \System\Object
{
    protected $UriStorage = '';
    
    public function __construct($UriStorage) 
    {
        $this->UriStorage = $UriStorage;
        try 
        {
            $this->CheckUriStorage();
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Can not construct cache', $Ex);
        }
    }
    
    public function ParseId($Id)
    {
        $Id = str_replace('/', '.', $Id);
        if ($Id[0] == '.') 
        {
            $Id = substr($Id, 1);
        }
        return $Id;
    }

    protected function CheckUriStorage()
    {
        if(!file_exists($this->UriStorage))
        {
            if(!mkdir($this->UriStorage, 0777, TRUE))
            {
                throw new \System\Exception('Can not create storage to cache');
            }
        }
    }

    public function Create($Id, $Info, $Content)
    { 
        $Id = $this->ParseId($Id);
        $CachePath = $this->UriStorage.'/'.$Id;
        if(!file_exists($CachePath))
        {
            if(!mkdir($CachePath, 0777, TRUE))
            {
                throw new \System\Exception('Can not create storage to cache');
            }
        }
        /*Create html file*/
        if(file_exists($CachePath.'/Content.html') || file_exists($CachePath.'/Info.json')) 
        {
            return FALSE;
        }
        file_put_contents($CachePath.'/Content.html', $Content);
        file_put_contents($CachePath.'/Info.json', json_encode($Info));        
    }   
    
    public function Update($Id, $Info, $Content)
    {
        
    }
    
    public function Select($Id)
    {
        $Id = $this->ParseId($Id);
        return file_get_contents($this->UriStorage.'/'.$Id.'/Content.html');
    }
    
    public function Delelte($Id)
    {
        try 
        {
            $Id = $this->ParseId($Id);
            $PathContent = $this->UriStorage.'/'.$Id.'/Content.html';
            $PathInfo = $this->UriStorage.'/'.$Id.'/Info.json';
            if (file_exists($PathContent)) 
            {
                unlink($PathContent);
            }
            if (file_exists($PathInfo)) 
            {
                unlink($PathInfo);
            }      
            return FALSE;
        }
        catch (\System\Exception $Ex) 
        {
            return FALSE;
        }
    }

    public function IsExist($Id)
    {
        $Id = $this->ParseId($Id);
        if (file_exists($this->UriStorage.'/'.$Id.'/Content.html') && file_exists($this->UriStorage.'/'.$Id.'/Info.json'))
        {
            return TRUE;
        }
        return FALSE;
    }  
    
    public function GetInfo($Id)
    {
        try
        {
            $Id = $this->ParseId($Id);
            return json_decode(file_get_contents($this->UriStorage.'/'.$Id.'/Info.json'));
        } 
        catch (\System\Exception $Ex) 
        {
            return FALSE;
        }
    }
}
