<?php
namespace System\Web\Caching;

class Info extends \System\Object
{
    protected $Info = array();
    
    public function FromJson($Path)
    {
        try 
        {
            $this->Info = json_decode(file_get_contents($Path));
            if (!is_array($this->Info))
            {
                throw new \System\Exception('Decode json file get wrong type');
            }
        } 
        catch (Exception $Ex) 
        {
            throw new \System\Exception('Can not read info file', $Ex);
        }       
    }
    
    public function FromArray($Info)
    {
        if (is_array($Info)) 
        {
            $this->Info = $Info;
        }
        else 
        {
            throw new \System\Exception('Info must array type');
        }
    }
    
    public function CompareTo($Info)
    {
        foreach ($this->Info as $Key => $Value) 
        {
            if (!isset($Info[$Key])) 
            {
                return FALSE;
            }
            if ($Value < $Info[$Key]) 
            {
                return FALSE;
            }
        }
    }
}