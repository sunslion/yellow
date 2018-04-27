<?php
defined('_VALID') or die('Restricted Access!');
class Channels extends Base{
    public function onIndex() {
        $seo = array(
            'title'=>$this->conf['site_title'],
            'keyword'=>$this->conf['meta_keywords'],
            'description'=>$this->conf['meta_description'],
        );
        $this->pushAssigns($seo);
        $this->tpls = array('channels.tpl');
    }
}
?>