<?php
namespace Application\Modules\Test\L1\Views\Index;

class Index extends \System\Web\Mvcm\View
{    
    protected function Config()
    {
        parent::Config();
        $this->SrcHtmlFw = \System\SystemLoader::GetDirSourceFramewrokHtml();
        $this->SrcHtmlStatic = $this->SrcHtml.'/Test';
        
        return TRUE;
    }   
}