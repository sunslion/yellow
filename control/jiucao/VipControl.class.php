<?php
defined('_VALID') or die('Restricted Access!');
class Vip extends Base{
    public function onIndex(){
        $type = get_request_arg('type','STRING');
        $tpl = '';
        $qq_1 = '';
        $qq_2 = '';
        $domain = '';
        if ($type === 'r') {
            $tpl = $this->conf['set_r_vip'];
            $qq_1 = $this->conf['rqq1'];
            $qq_2 = $this->conf['rqq2'];
            $domain = $this->conf['rdomain'];
        }else{
            $tpl = $this->conf['set_l_vip'];
            $qq_1 = $this->conf['lqq1'];
            $qq_2 = $this->conf['lqq2'];
            $domain = $this->conf['ldomain'];
        }
        if (empty($tpl)) {
            Libs_Redirect::go('/');
        }
        $this->pushAssigns(array('domain'=>$domain,'qq1'=>$qq_1,'qq2'=>$qq_2));
        $this->tpls = array('vip/'.$tpl.'.tpl');
    }
}
?>
