<?php
namespace System\Web\Mvcm;

interface IActionFilter
{
    function OnActionExecuted($filterContext);
    function OnActionExecuting($filterContext);    
}