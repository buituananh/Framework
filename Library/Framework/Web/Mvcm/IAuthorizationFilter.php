<?php
namespace System\Web\Mvcm;

interface IAuthorizationFilter
{
    function OnAuthorization($filterContext);
}