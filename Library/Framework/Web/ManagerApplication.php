<?php
namespace System\Web;

class ManagerApplication
{
    /**
     * Contain application object 
     */
    protected $Applications = array();
    
    /**
     * Load base class for application
     */
    protected function InitEnvMvcm()
    {
        \System\CodeManager::LoadInterface('/Web/Mvcm/IActionFilter');
        \System\CodeManager::LoadInterface('/Web/Mvcm/IAuthorizationFilter');
        \System\CodeManager::LoadInterface('/Web/Mvcm/IExceptionFilter');
        \System\CodeManager::LoadInterface('/Web/Mvcm/IResultFilter');  
        \System\CodeManager::LoadInterface('/Web/Mvcm/IController'); 
        
        \System\CodeManager::Load('/Web/Mvcm/Application');
        \System\CodeManager::Load('/Web/Mvcm/Controller');
        \System\CodeManager::Load('/Web/Mvcm/ControllerManager');
        \System\CodeManager::Load('/Web/Mvcm/ModelManager');
        \System\CodeManager::Load('/Web/Mvcm/ModuleManager');
        \System\CodeManager::Load('/Web/Mvcm/ViewManager');
        \System\CodeManager::Load('/Web/Mvcm/Model');
        \System\CodeManager::Load('/Web/Mvcm/Module');
        \System\CodeManager::Load('/Web/Mvcm/ActionResult');
        \System\CodeManager::Load('/Web/Mvcm/ResultApplication');
        \System\CodeManager::Load('/Web/Mvcm/ResultController');
        \System\CodeManager::Load('/Web/Mvcm/ResultModule');
        \System\CodeManager::Load('/Web/Mvcm/Router');
        \System\CodeManager::Load('/Web/Mvcm/View');        
        \System\CodeManager::Load('/Web/Mvcm/ViewResult');
        \System\CodeManager::Load('/Web/Mvcm/JsonResult');
        \System\CodeManager::Load('/Web/Mvcm/RedirectResult');
        \System\CodeManager::Load('/Web/Mvcm/FileContentResult');
        \System\CodeManager::Load('/Web/Mvcm/FileStreamResult');        
        \System\CodeManager::Load('/Web/Mvcm/QuitResult');
        \System\CodeManager::Load('/Web/Mvcm/ContentResult');
        \System\CodeManager::Load('/Web/Mvcm/FilePathResult');
        \System\CodeManager::Load('/Web/Mvcm/HttpNotFoundResult');
        \System\CodeManager::Load('/Web/Mvcm/JavaScriptResult');     
        
        \System\CodeManager::Load('/Web/Caching/Cache');
        \System\CodeManager::Load('/Web/Optimization/Scripts');
        \System\CodeManager::Load('/Web/Optimization/Styles');
        \System\CodeManager::Load('/Web/Routing/RequestContext');
        \System\CodeManager::Load('/Web/Security/Authorization');
        \System\CodeManager::Load('/Web/Security/Roles');
        
        \System\CodeManager::Load('/Web/HtmlTag');
        
        return TRUE;
    }
    
    /**
     * Create new mvcm application
     * @param type $Path
     * @param type $Space
     */
    public function NewMvcm($Path, $Space)
    {
        /*Check Framework inited*/
        if (!$this->InitEnvMvcm()) 
        {
            throw new \System\Exception('Can not init environment Mvcm');
        }
        /*Create application*/ 
        try 
        {            
            $this->Applications[$Path] = \System\Generator::NewObject($Path.'/Application', $Space.'\Application');
        } 
        catch (\System\Exception $Ex) 
        {            
            throw new \System\Exception('Can not create application', $Ex);
        }       
        /*Respond success*/
        return $this->Applications[$Path];        
    }
}