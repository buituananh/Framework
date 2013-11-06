<?php
namespace System\Web\Mvcm;

class ControllerManager extends \System\Object
{
    protected $AllowSet = array('Module');
    protected $Module = NULL;    
    protected $Controllers = array();
    
    public function CreateController($Name) 
    {
        try
        {
            /*Controller exist*/
            if (isset($this->Controllers[$Name])) return $this->Controllers[$Name];
            /*Create controller*/
            $Controller = \System\Generator::NewObject($this->GetDirPath().'/Controllers/'.$Name, $this->GetSpace().'\Controllers\\'.$Name);        
            $Controller->Set('Module', $this->Module);
            $this->Controllers[$Name] = $Controller;
            /*Return it*/
            return $this->Controllers[$Name];            
        }
        catch (\Exception $Ex)
        {
            throw new \Exception('Controller invalid: Module = '.$this->GetSpace().'; Controller = '.$Name, 0, $Ex);
        }
    }
    
    public function GetController($Path)
    {
        /**/
        $MgrModule = NULL;
        $Module = NULL;
        try
        {
            if ($Path[0] == '~') 
            {
                $MgrModule = $this->Module->Get('MgrModule');
                $Path = substr($Path, 1);
                $Router = new Router($Path); 
                try
                {
                    $Module = $MgrModule->CreateModule($Router);
                }
                catch (\Exception $Ex)
                {
                    $Module = $this->Module;
                } 
            }
            else 
            {             
                $MgrModule = $this->Module->GetMgrModuleLeader();
                $Router = new Router($Path);
                $Module = $MgrModule->CreateModule($Router);            
            }            
            return $Module->Get('MgrController')->CreateController($Router->GetControllerName());
        }
        catch (\Exception $Ex)
        {
            throw new \Exception('Get controller fail: Module = '.$Router->GetModuleName().'; Controller = '.$Router->GetControllerName(), 0, $Ex);
        }
    }    
}