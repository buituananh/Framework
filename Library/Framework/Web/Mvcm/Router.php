<?php
namespace System\Web\Mvcm;

class Router extends \System\Object
{
    protected $AllowSet = array('ResultActionType', 'Path', 'PathArr', 'ControllerName', 'ActionName', 'ModuleName');
    protected $AllowGet = array('ResultActionType', 'Path', 'PathArr', 'ControllerName', 'ActionName', 'ModuleName');
    
    protected $Path = '';
    protected $PathArr = array();
    protected $ModuleName = '';
    protected $ControllerName = '';
    protected $ActionName = '';
    protected $Data;    
    protected $ResultActionType = '';
    
    public function __construct($Path, $Data = NULL) 
    {
        $this->Update($Path, $Data); 
    }
    
    public function IsEmpty()
    {        
        if (!empty($this->PathArr)) return FALSE;
        return TRUE;
    }

    public function Update($Path, $Data = NULL)
    {
        $this->Path = $Path;
        /*Modify direction (Cut URI start 0 to first '?'. '?' vail when use HTML form with get method)*/
        if (strpos($this->Path, '?') !== FALSE) 
        {
            $this->Path = substr($this->Path, 0, strpos($this->Path, '?'));                        
        }
        /*Parse Path is string to array and remove empty element*/                       
        $this->PathArr = array_filter(str_getcsv($this->Path, '/'), 'strlen');
        $this->PathArr = array_values($this->PathArr);
        /*Store data*/
        $this->Data = $Data;       
    }

    public function GetControllerName()
    {
        if (isset($this->PathArr[0])) 
        {
            return $this->PathArr[0];
        }
        else 
        {
            return NULL;
        }
    }
    
    public function GetModelName()
    {
        if (count($this->PathArr) > 1)
        {
            return FALSE;
        }
        if (isset($this->PathArr[0])) 
        {
            return $this->PathArr[0];
        }
        else 
        {
            return NULL;
        }
    }
    
    public function GetActionName()
    {
        if (count($this->PathArr) > 2)
        {
            return FALSE;
        }        
        if (isset($this->PathArr[1]))
        {
            return $this->PathArr[1];
        }
        else 
        {
            return NULL;
        }
    }
    
    public function SetControllerName($Name)
    {
        $this->PathArr[0] = $Name;
    }
    
    public function SetActionName($Name)
    {
        $this->PathArr[1] = $Name;
    }
    
    public function IsValid()
    {
        if (count($this->PathArr) > 2)            
        {
            return FALSE;       
        }
        return TRUE;
    }
    
    public function AddModuleName($Name)
    {
        $this->ModuleName = $this->ModuleName.'/'.$Name;
    }
    
    public function GetModuleName()
    {
        return $this->ModuleName;
    }
    
    public function GetRealPath()
    {
        return $this->GetModuleName().'/'.$this->GetControllerName().'/'.$this->GetActionName();
    }
}