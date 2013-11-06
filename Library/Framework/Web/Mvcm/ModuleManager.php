<?php
namespace System\Web\Mvcm;

class ModuleManager extends \System\Object
{
    protected $AllowGet = array('ModuleParent');
    protected $ModuleChilds = array();
    protected $ModuleParent = NULL;    
    protected $AllowSet = array('ModuleParent');
    public $Application;


    /**
     * Create module
     * @param \System\Web\Mvcm\ApplicationCore\Router $Router
     * @return type
     * @throws Exception
     */
    public function CreateModule(&$Router)
    {
        /*Get path array*/
        $PathArr = $Router->Get('PathArr');         
        /*Init ManagerModuleNow*/
        $MgrModuleNow = $this;
        /*Init ModuleNow, Module*/
        $ModuleNow = NULL;
        $Module = NULL;
        /*Init path to module file*/
        $ModulePath = '';
        /*Init class id to module*/
        $ModuleClass = '';
        /*Init module name*/
        $ModuleName = '';
        /*Try create until can not create*/
        while (!empty($PathArr))
        {
            /*Get module name*/ 
            $ModuleName = array_shift($PathArr);  
            /*Get path to module file*/
            $ModulePath = $MgrModuleNow->GetDirPath().'/Modules/'.$ModuleName.'/Module'; 
            /*Get class of module*/
            if ($MgrModuleNow->IsMgrModuleLeader()) 
            {
                $ModuleClass = $MgrModuleNow->GetSpace().'\Modules\\'.$ModuleName.'\Module';
            }
            else
            {
                $ModuleClass = $MgrModuleNow->GetSpace().'\\'.$ModuleName.'\Module';
            }
            /*Try create module*/ 
            try 
            { 
                $ModuleNow = \System\Generator::NewObject($ModulePath, $ModuleClass);
                $ModuleNow->Application = $this->Application;
            } 
            catch (\System\Exception $Ex) 
            { 
                /*Break if can not create, push module name to PathArr again*/
                array_unshift($PathArr, $ModuleName); 
                break;
            }              
            /*If created, change PathArr and MgrModuleNow and continue*/                        
            $Module = $ModuleNow;  
            $Module->Set('MgrModuleParent', $MgrModuleNow);
            $this->ModuleChilds[$ModuleName] = $Module;            
            $MgrModuleNow = $ModuleNow->Get('MgrModule');              
            $Router->AddModuleName($ModuleName);
        }
        /*If ModuleNow is null mean can not create any module, throw Exception*/
        if (!$Module) 
        {
            throw new \System\Exception('No module created');    
        }
        /*Create module done, change router*/
        $Router->Set('PathArr', $PathArr);        
        /*Return module*/
        return $Module;
    } 
    
    public function IsMgrModuleLeader()
    {
        if ($this->ModuleParent) 
        {
            return FALSE;
        }
        return TRUE;
    }    
}