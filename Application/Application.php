<?php
namespace Application;

class Application extends \System\Web\Mvcm\Application
{
    protected $ModuleDef = '/Home/Center/Classic';
    protected $ReportOn = false;
    protected $CacheOn = false;
    
    public function OnCompleteConstruct() 
    {
        $ConnectionAttr['Server'] = $this->Config->Connections->Default->Server;
        $ConnectionAttr['User'] = $this->Config->Connections->Default->User;
        $ConnectionAttr['Password'] = $this->Config->Connections->Default->Password;
        $ConnectionAttr['Database'] = $this->Config->Connections->Default->Database;
        \System\Web\Security\User::SetDatabase($ConnectionAttr, 'sys_users', 'Id', 'UserName');
        \System\Web\Security\Roles::SetDatabase($ConnectionAttr);
//        \System\Web\Authentication::Authorize();
    }
    
    public function OnCompleteRun() 
    {
        \System\Web\Security\User::Dispose();
    }
}