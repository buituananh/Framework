<?php
namespace System\Web\Mvcm;

class ViewManager extends \System\Object
{
    protected $Views = array();
    protected $AllowSet = array('Module');
    protected $Module = NULL;
    
    public function CreateView($ControllerName, $ViewName) 
    {
        try
        {
            /*Check view created. If created respond it created*/ 
            if (isset($this->Views[$ControllerName][$ViewName])) 
            {
                return $this->ListView[$ControllerName][$ViewName];   
            }
            /*Determine class view*/
            $ViewClass = $this->GetSpace().'\Views\\'.$ControllerName.'\\'.$ViewName;   
            /*Determine class path*/
            $ViewPath = $this->GetDirPath().'/Views/'.$ControllerName.'/'.$ViewName.'/View'; 
            /*Ceate view object and save it to property of manager view*/            
            $this->ListView[$ControllerName][$ViewName] = \System\Generator::NewObject($ViewPath, $ViewClass);            
            $this->ListView[$ControllerName][$ViewName]->Set('Module', $this->Module);
            /*Respond success*/
            return $this->ListView[$ControllerName][$ViewName];                        
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Create View fail ', $Ex);
        }
    }    
}