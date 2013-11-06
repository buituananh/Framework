<?php
namespace Application\Modules\Shared\Views\Home;

class Classic extends \System\Web\Mvcm\View
{
    protected $Title = 'Project center';
    protected $Icon = '/Sources/Shared/Img/Logo.ico';
    protected $JQueryEnable = TRUE;
    protected $AppSetting;
    protected $AppVersion;
    
    protected function OnPreRender() 
    {
        $AppConfig =  $this->Module->Application->Get('Config');
        $this->AppSetting = $AppConfig->Setting;
        $this->AppVersion = new \System\Version(
                $AppConfig->Version->Major, 
                $AppConfig->Version->Minor,
                $AppConfig->Version->Build, 
                $AppConfig->Version->Revision, 
                $AppConfig->Version->DateCreated,
                $AppConfig->Version->DateModified
        );
    }
}