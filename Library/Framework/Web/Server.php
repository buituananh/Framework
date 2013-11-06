<?php
namespace System\Web;

class Server
{
    static public function MapPath($Path)
    {
        return \System\Environment::GetServerPath().$Path;
    }
    
    static public function MapRootPath($Path)
    {
        return \System\Environment::GetRootPath().$Path;
    }
}
