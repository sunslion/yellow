<?php
defined('_VALID') or die('Restricted Access!');
class UpdateDom extends Base{
    public function onIndex(){
        $UpdateDomModel = $this->modelFactory->get('UpdateDom');
        $Date = $UpdateDomModel->getAll();
    }
}
