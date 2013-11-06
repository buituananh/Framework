<?php
namespace System\Web\Mvcm;

interface IResultFilter
{
    function OnResultExecuted($filterContext);
    function OnResultExecuting($filterContext);  
}