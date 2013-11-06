<?php
namespace Application\Modules\Support\Controllers;

class Index extends \System\Web\Mvcm\Controller
{   
    public function Index()
    {
        $Data['Support'] = $this->GetModel('/Article/ArticleTask')->GetSupportArticle();
        return $this->View(NULL, $Data);
    }
}