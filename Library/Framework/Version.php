<?php
namespace System;

class Version extends \System\Object
{
    protected $AllowGet = array('Major', 'Minor', 'Build', 'Revision', 'DateCreated', 'DateModified');

    protected $Major = 0;
    protected $Minor = 0;
    protected $Build = 0;
    protected $Revision = 0;
    protected $DateCreated = '';
    protected $DateModified = '';


    public function __construct($Major = 0, $Minor = 0, $Build = 0, $Revision = 0, $DateCreated = '', $DateModified = '') 
    {
        $this->Major = $Major;
        $this->Minor = $Minor;
        $this->Build = $Build;
        $this->Revision = $Revision;
        $this->DateCreated = $DateCreated;
        $this->DateModified = $DateModified;
    }

    public function Compare($Version)
    {
        
    }
    
    public function GetString()
    {
        return $this->Major.'.'.$this->Minor.'.'.$this->Build.'.'.$this->Revision;
    }
}