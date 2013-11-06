<?php
namespace Application\Modules\Article\Controllers;

class Index extends \System\Web\Mvcm\Controller
{
    public function Index()
    {
        $Data['ExcellentArticle'] = $this->GetModel('~/ArticleTask')->GetExcellentArticle();
        $Data['Class'] = $this->GetModel('~/ArticleTask')->GetCoolArticle();
        return $this->View(NULL, $Data);
    }
}