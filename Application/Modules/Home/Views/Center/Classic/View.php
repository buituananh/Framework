<?php
namespace Application\Modules\Home\Views\Center;

include dirname(dirname(dirname(dirname(__DIR__)))).'/Shared/Views/Home/Classic/View.php';
class Classic extends \Application\Modules\Shared\Views\Home\Classic
{
    protected $Title = 'Home center';
    protected $Icon = '/Sources/Shared/Img/Logo.ico';
    protected $JQueryEnable = TRUE;
    
}