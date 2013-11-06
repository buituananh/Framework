<?php
namespace System;

class Object
{
    protected $AllowGet = array();
    protected $AllowSet = array();

    /**
     * Get namespace contain this class
     */
    public function GetSpace()
    {
        /*Create Reflection to get namespace of object, where class define*/
        $ReflectionClass = new \ReflectionClass($this);
        /*Return namespace, may be false*/
        return '\\'.$ReflectionClass->getNamespaceName();         
    }    

    /**
     * Get file contain this class
     */
    public function GetFilePath()
    {
        /*Create Reflection to get file contain Object*/
        $ReflectionObject = new \ReflectionObject($this);
        /*Return file contain Object, may be false*/
        return $ReflectionObject->getFileName();        
    }
    
    /**
     * Get directory contain file contain this class
     */
    public function GetDirPath()
    {
        return dirname($this->GetFilePath());
    }    
    
    /**
     * Get class name
     */
    public function GetName()
    {
        /*Create Reflection to get class of object, where class define*/
        $ReflectionClass = new \ReflectionClass($this);
        /*Return namespace, may be false*/
        return '\\'.$ReflectionClass->getName();            
    }
    
    /**
     * Get type of class by /<namespace>/<class name>
     */
    public function GetType()
    {
        return get_class($this);
    }
    
    /**
     * Get property if in AllowGet
     * @param type $Property
     */
    public function Get($Property)
    {
        /*Check property exist in object*/
        if (!property_exists($this, $Property)) 
        {
            throw new \System\Exception('Property '.$Property.' is not exist in '.$this->GetType().' in file '.$this->GetFilePath());
        }
        /*Check property allow get*/
        if (!in_array($Property, $this->AllowGet)) 
        {
            throw new \System\Exception('Property '.$Property.' is not allow get in '.$this->GetType().' in file '.$this->GetFilePath());
        }
        /*Return property*/
        return $this->$Property;        
    }
    /**
     * Set property if in AllowSet
     * @param type $Property
     * @param type $Value
     */
    public function Set($Property, $Value)
    {
        /*Check property exist in object*/
        if (!property_exists($this, $Property)) 
        {
            throw new \System\Exception('Property '.$Property.' is not exist in '.$this->GetType().' in file '.$this->GetFilePath());
        }
        /*Check property allow set*/
        if (!in_array($Property, $this->AllowSet))
        {
            throw new \System\Exception('Property '.$Property.' is not allow set in '.$this->GetType().' in file '.$this->GetFilePath());
        }
        /*Set property*/
        $this->$Property = $Value;        
    }
}