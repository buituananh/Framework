<?php
namespace System\Web\Mvcm;

class Application extends \System\Object
{
    protected $AllowGet = array('Config');
    protected $MgrModule = NULL;
    protected $Src = '';
    protected $Connection = array();
    protected $ModuleDef = '';
    protected $ReportOn = FALSE;
    protected $CacheOn = FALSE;
    protected $Config;

    public function __construct()
    {
        try 
        {
            /*Read config*/
            $this->Config = json_decode(file_get_contents($this->GetDirPath().'/Application.json'));                
            /*Create MgrModule*/
            $this->MgrModule = \System\Generator::NewObject($this->GetDirPath().'/ModuleManager', $this->GetSpace().'\ModuleManager');               
            $this->MgrModule->Application = $this;
            /*Strart session*/
            session_start();
            $this->OnCompleteConstruct();
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Can not init application', $Ex);
        } 
    }
    
    protected function OnCompleteConstruct()
    {
        
    }
    
    protected function OnCompleteRun()
    {
        
    }

    public function Run($Router)
    { 
        /*Fix Router by ModuleDef*/
        if ($Router->IsEmpty()) 
        {
            $Router->Update($this->ModuleDef);
        }
        /*Use MgrModule + Router to create Module and run*/
        try 
        {
            /*Check cache*/
            $Cache = new \System\Web\Caching\Cache($this->GetDirPath().'/Cache');
            $IdCache = $Router->Get('Path');             
            $CacheHit = FALSE;
            $Process = TRUE;
            if ($this->CacheOn)
            { 
                if ($Cache->IsExist($IdCache))
                { 
                    $CacheInfo = $Cache->GetInfo($IdCache);                    
                    if ($this->IsValidCache($CacheInfo))
                    { 
                        echo $Cache->Select($IdCache);
                        $CacheHit = TRUE;
                        $Process = FALSE;
                    }
                }                
            } 
            if ($Process)
            {
                ob_start();  
                /*Process*/ 
                $Module = $this->MgrModule->CreateModule($Router);   
                /**/             
                $ResultModule = $Module->Run($Router);   
                /*Caching*/ 
                if ($this->CacheOn)
                {
                    $CacheInfo = array();
                    $CacheInfo['ModuleName'] = $Router->GetModuleName();
                    $CacheInfo['ControllerName'] = $Router->GetControllerName();                
                    $CacheInfo['ActionName'] = $Router->GetActionName();
                    $CacheInfo['ControllerModified'] = $ResultModule->ControllerModified;
                    $CacheInfo['ViewModified'] = $ResultModule->ViewModified;
                    $CacheInfo['ViewRenderModified'] = $ResultModule->ViewRenderModified;
                    $Cache->Delelte($IdCache);
                    $Cache->Create($IdCache, $CacheInfo, ob_get_contents());                    
                }
            }                     
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Application run fail', $Ex);
        }  
        /*Show report if enable and result is view action*/
        if($this->ReportOn && $Router->Get('ResultActionType') != 'Json') 
        {     
            include_once __DIR__.'/Report/GI/WorkFlow.phtml';        
        } 
        $this->OnCompleteRun();
    }
    
    protected function IsValidCache($Info)
    {
        /*Check controller modified*/
        $Path = $this->MapControllerPath($Info->ModuleName, $Info->ControllerName);
        if (filemtime($Path) > $Info->ControllerModified) 
        {
            return FALSE;
        }
        /*Check view modified*/
        $Path = $this->MapViewDirPath($Info->ModuleName, $Info->ControllerName, $Info->ActionName);
        if($Info->ViewModified > 0)
        {
            if (file_exists($Path.'/View.php'))
            {
                if (filemtime($Path.'/View.php') > $Info->ViewModified) 
                {
                    return FALSE;
                }            
            }             
        }
        if($Info->ViewRenderModified > 0)
        {
            if (file_exists($Path.'/View.phtml'))
            {
                if (filemtime($Path.'/View.phtml') > $Info->ViewRenderModified) 
                {
                    return FALSE;
                }             
            }             
        }              
        return TRUE;
    }  
    
    public function MapModuleDirPath($ModuleName)
    {
        return $this->GetDirPath().str_replace('/', '/Modules/', $ModuleName);
    }  
    
    public function MapControllerPath($ModuleName, $ControllerName)
    {
        return $this->MapModuleDirPath($ModuleName).'/Controllers/'.$ControllerName.'.php';
    }
    
    public function MapViewDirPath($ModuleName, $ControllerName, $ActionName)
    {
        return $this->MapModuleDirPath($ModuleName).'/Views/'.$ControllerName.'/'.$ActionName;
    }    
    
}