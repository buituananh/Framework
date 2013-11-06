<?php
namespace Application\Modules\Test\L1\L2\L3\Controllers;

class Index extends \System\Web\Mvcm\Controller
{
    public $Security = array(
        'Require'=>TRUE,
        'Http'=>TRUE,
        'PmsType'=>array(0, 1)
    );    
    public $SecurityMethod = array(
        'Index'=>array(
            'Require'=>TRUE,
            'Http'=>TRUE,
            'PmsType'=>array(0, 1)
            )
    );        
    public function Index()
    {               
        
        return $this->View();
    }
}
?>
