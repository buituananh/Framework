<?php
namespace System\Web\Mvcm;

abstract class Controller extends \System\Object 
implements IActionFilter, IAuthorizationFilter, \System\IDisposable, IExceptionFilter, IResultFilter, IController
{
    protected $AllowGet = array('ActionDef');
    protected $ActionDef = 'Index';    
    protected $AllowSet = array('Module');
    protected $Module = NULL;
    protected $ViewBag;


    protected function GetModel($Path) 
    {
        try
        {
            return $this->Module->GetModel($Path);
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Controller get model fail: Path = '.$Path, $Ex);
        }
    }
    
    protected function GetController($Path) 
    {
        try
        {
            return $this->Module->GetController($Path);
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Controller get controller fail: Path = '.$Path, $Ex);
        }
    }
    
    protected function View($Name = NULL, $Data = NULL)
    {
        /*Debug to get some things*/ 
        $Callers = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);        
        /*Determine class name of controller (not contain namespace)*/
        $ControllerName = substr($Callers[1]['class'], strrpos($Callers[1]['class'], '\\') + 1); 
        /*Determine method call this method*/
        if (empty($Name)) 
        {
            $ActionName = $Callers[1]['function'];    
        }
        else 
        {
            $ActionName = $Name;
        }
        return new ViewResult($this->Module, $ControllerName, $ActionName, $Data, $this->ViewBag);        
    }   
    
    protected function Json($Data)
    {
        return new JsonResult($Data);
    }
    
    protected function FileContent($FileContent, $Type = NULL, $Name = NULL, $Encode = NULl)
    {
        return new FileContentResult($FileContent, $Type, $Name, $Encode);
    }
    
    protected function FileStream($Stream, $Type = NULL, $Name = NULL, $Encode = NULl)
    {
        return new FileStreamResult($Stream, $Type, $Name, $Encode);
    }
        
    protected function FilePath($FilePath, $FileType = NULL, $FileName = NULL, $FileEncode = NULl)
    {
        return new FilePathResult($FilePath, $FileType, $FileName, $FileEncode);
    }
    
    protected function Redirect($Uri)
    {
        return new RedirectResult($Uri);
    }

    protected function Quit()
    {
        return new QuitResult();
    }   
    
    protected function Content($Content, $ContentType = NULL, $ContentEncoding = NULL)
    {
        return new ContentResult($Content, $ContentType, $ContentEncoding);
    }      
    
    protected function HttpNotFound($StatusDescription = 'NOT FOUND')
    {
        return new HttpNotFoundResult($StatusDescription);
    }
    
    protected function JavaScript($Script)
    {
        return  new JavaScriptResult($Script);
    }
    
    public function Dispose() 
    {
        
    }
    
    public function OnActionExecuted($filterContext) 
    {
        
    }
    
    public function OnActionExecuting($filterContext)
    {
        
    }
    
    public function OnAuthorization($FilterContext = NULL) 
    {
        
    }

    public function OnException($filterContext) 
    {
        
    }

    public function OnResultExecuted($filterContext) 
    {
        
    }

    public function OnResultExecuting($filterContext) 
    {
        
    }

    public function Execute($RequestContext) 
    {

    }
}