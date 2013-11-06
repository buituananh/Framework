<?php
namespace Application\Modules\Test\L1\L2;

class Module extends \System\Web\Mvcm\Module
{
    public $Security = array(
        'Require'=>TRUE,
        'Http'=>TRUE,
        'PmsType'=>array(0, 1)
    );    
}
