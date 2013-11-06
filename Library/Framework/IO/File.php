<?php
namespace System\IO;

class File
{
    protected $Path;
    protected $Content;
    

    public function __construct($Path) 
    {
        $this->Path = $Path;
    }
    
    public function GetPath()
    {
        return $this->Path;
    }

    public function IsExist()
    {
        return file_exists($this->Path);
    }
    
    public function Write()
    {
        file_put_contents($this->Path, $this->Content);
    }
    
    public function Read()
    {
        $this->Content = file_get_contents($this->Path);
    }
    
    public function SetContent($FileContent)
    {
        $this->Content = $FileContent;
    }
    
    public function GetContent()
    {
        return $this->Content;
    }
    
    public function ReName($Name)
    {
        return rename($this->Path, dirname($this->Path).'\\'.$Name); 
    }
    
    public function CopyTo($Path)
    {
        return copy($this->Path, $Path);
    }
    
    public function CutTo($Path)
    {
        return rename($this->Path, $Path); 
    }

    public function Delete()
    {
        unlink($this->Path); 
    }
    
    public function GetSize()
    {
        if(!$this->IsExist()) 
        {
            return 0;
        }
        return filesize($this->Path);
    }
}