<?php
namespace System\Web\Mvcm;

class Module extends \System\Object
{
    protected $MgrModule;
    protected $MgrModuleParent;
    protected $MgrController;
    protected $MgrModel;
    protected $MgrView;
    protected $ControllerDef = 'Index';    
    protected $AllowGet = array('MgrModuleParent', 'MgrModule', 'MgrController', 'MgrModel', 'MgrView');
    protected $AllowSet = array('MgrModuleParent');
    public $Application;

    public function __construct()
    {
        /*Crete manager: MgrController, MgrModel, MgrView, MgrModule*/
        try
        {
            $this->CreateModuleMgr();           
            $this->OnAuthentication();  
        }
        catch (\Exception $Ex)
        {
            throw new \Exception('Construct module fail: '.$Ex->getMessage());
        }
    }

    public function Run(&$Router) 
    { 
        
        /*Run controller and get ResultAction*/
        try
        {
            
            /*Check valid Router*/
            if (!$Router->IsValid()) 
            {
                throw new \Exception('Router invalid');
            }
            /*Get controller default*/
            if (!$Router->GetControllerName()) 
            {
                $Router->SetControllerName($this->ControllerDef);
            }
            /*Denie all invoke to base method of controller*/
            $RefMethod = new \ReflectionClass('\System\Web\Mvcm\Controller');
            $Methods = array();
            foreach ($RefMethod->getMethods() as $Value)
            {
                array_push($Methods, $Value->name);
            }
            if (in_array($Router->GetActionName(), $Methods)) 
            {
                throw new \System\Exception('Can not call base method of controller');
            }            
            /*Use Router + MgrController to create Controller*/
            $this->CreateControllerMgr();
            $Controller = $this->MgrController->CreateController($Router->GetControllerName());   
            $Controller->OnAuthorization();
            if(!\System\Web\Security\Authorization::IsValid())
            {
                $HttpNotFound = new HttpNotFoundResult('Authentication app fail');
                $HttpNotFound->Execute();
                exit();
            }               
            /*Get action default*/
            if (!$Router->GetActionName())
            {
                $Router->SetActionName($Controller->Get('ActionDef'));
            }
            /*Use Router to execute Action of Controller and get ResultAction*/
            if (!method_exists($Controller, $Router->GetActionName())) 
            {
                throw  new \Exception('Action invalid: Module = '.$this->GetSpace().'; Controller = '.$Router->GetControllerName().'; Action = '.$Router->GetActionName());
            }
            /*Check protected or private action*/
            $MethodRef = new \ReflectionMethod($Controller, $Router->GetActionName());            
            if (!$MethodRef->isPublic()) 
            {
                throw new \Exception('Execute protected or private action');
            }
            /**/
            
            /*Execute action and get result*/
            $ResultAction = $Controller->{$Router->GetActionName()}(); 
            if (!$ResultAction instanceof \System\Web\Mvcm\ActionResult)
            {
                throw new \System\Exception('Controller not return ActionResult');
            }
            /**/
            if(!\System\Web\Security\Authorization::IsValid())
            {
                $Uri = $this->Application->Get('Config')->Authentication->LoginUri;
                $RedirectResult = new RedirectResult($Uri);
                $RedirectResult->Execute();
            }
            else
            {
                /*Excute result action to Router*/
                $ResultAction->Execute();                
            }
            /**/
            $ResultModule = new ResultModule();
            $ResultModule->ControllerModified = filemtime($Controller->GetFilePath());            
            if (get_class($ResultAction) == 'System\Web\Mvcm\ResultView')
            {
                $ViewPath = $this->GetDirPath().'/Views/'.$Router->GetControllerName().'/'.$Router->GetActionName();
                $ResultModule->ViewModified = filemtime($ViewPath.'/View.php');
                if (file_exists($ViewPath.'/View.phtml'))
                {
                    $ResultModule->ViewRenderModified = filemtime($ViewPath.'/View.phtml');
                }                
            } 
            /**/
            return $ResultModule;                       
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Module run fail', $Ex);
        }                
    }
    
    public function GetMgrModuleLeader()
    {
        /**/
        $Module = $this;
        while (TRUE) 
        {
            if (!$Module->Get('MgrModuleParent')->Get('ModuleParent')) return $Module->Get('MgrModuleParent');
        }        
    }  
    
    public function CreateControllerMgr()
    {
        try 
        {
            if ($this->MgrController != NULL) 
            {
                return;
            }
            /*Create MgrController*/
            $this->MgrController = \System\Generator::NewObject($this->GetDirPath().'/ControllerManager', $this->GetSpace().'\ControllerManager');
            $this->MgrController->Set('Module', $this);             
        } 
        catch(\System\Exception $Ex)
        {
            throw new \System\Exception('Can not create manager controller', $Ex);
        }
    }
    
    public function CreateViewMgr()
    {
        try 
        {
            if ($this->MgrView != NULL) 
            {
                return;
            }            
            /*Create MgrView*/
            $this->MgrView = \System\Generator::NewObject($this->GetDirPath().'/ViewManager', $this->GetSpace().'\ViewManager');      
            $this->MgrView->Set('Module', $this);           
        } 
        catch(\System\Exception $Ex)
        {
            throw new \System\Exception('Can not create manager view', $Ex);
        }
    }
    
    public function CreateModelMgr()
    {
        try 
        {
            if ($this->MgrModel != NULL) 
            {
                return;
            }            
            /*Create MgrModel*/
            $this->MgrModel = \System\Generator::NewObject($this->GetDirPath().'/ModelManager', $this->GetSpace().'\ModelManager');       
            $this->MgrModel->Set('Module', $this);            
        } 
        catch(\System\Exception $Ex)
        {
            throw new \System\Exception('Can not create manager model', $Ex);
        }
    }    

    public function CreateModuleMgr()
    {
        try 
        {
            if ($this->MgrModule != NULL) 
            {
                return;
            }            
            /*Create MgrModule*/
            $this->MgrModule = \System\Generator::NewObject($this->GetDirPath().'/ModuleManager', $this->GetSpace().'\ModuleManager');
            $this->MgrModule->Set('ModuleParent', $this);           
        } 
        catch(\System\Exception $Ex)
        {
            throw new \System\Exception('Can not create manager module', $Ex);
        }
    } 
    
    public function GetController($Path)
    {
        try
        {
            $this->CreateMgrController();
            return $this->MgrController->GetController($Path);
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Controller get controller fail: Path = '.$Path, $Ex);
        }        
    }
    
    public function GetModel($Path)
    {
        try
        {
            $this->CreateModelMgr();
            return $this->MgrModel->GetModel($Path);
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Controller get model fail: Path = '.$Path, $Ex);
        }        
    }   
    
    public function GetView($ControllerName, $ViewName)
    {
        try
        {
            $this->CreateViewMgr();
            return $this->MgrView->CreateView($ControllerName, $ViewName);
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Controller get view fail', $Ex);
        }        
    }     
    
    public function OnAuthentication()
    {
        
    }
}