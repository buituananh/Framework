<?php
namespace System\Web\Mvcm;

interface IExceptionFilter
{
    function OnException($filterContext);
}