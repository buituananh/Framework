<?php
namespace System\Web\Mvcm;

class ModelManager extends \System\Object
{
    protected $AllowSet = array('Module');
    protected $Module = NULL;

    public function CreateModel($Name) 
    {
        try
        {
            /*Controller exist*/
            if (isset($this->Models[$Name])) 
            {
                return $this->Models[$Name];
            }
            /*Create controller*/
            $Model = \System\Generator::NewObject($this->GetDirPath().'/Models/'.$Name, $this->GetSpace().'\Models\\'.$Name);        
            $Model->Set('Module', $this->Module);
            $Model->OnPreCompleteConstruct();
            $Model->OnCompleteConstruct();
            $this->Models[$Name] = $Model;
            /*Return it*/
            return $this->Models[$Name];            
        }
        catch (\Exception $Ex)
        {
            throw new \Exception('Model invalid: Module = '.$this->GetSpace().'; Model = '.$Name, 0, $Ex);
        }
    }
    
    public function GetModel($Path)
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
            /**/
            $Module->CreateModelMgr();
            return $Module->Get('MgrModel')->CreateModel($Router->GetModelName());            
        } 
        catch (\Exception $Ex) 
        {
            throw new \Exception('Get model fail: Path = '.$Path, 0, $Ex);
        }
    }    
}