<?php
defined('_VALID') or die('Restricted Access!');
class Search extends Base
{
    public function onIndex(){
        $filter = new Libs_Filter();
        //$kd = $filter->get('kd','STRING','POST');
        $kd = $_REQUEST['kd'];
        if (empty($kd)) {
            $kd = get_request_arg('kd','STRING');
        }
        $kd = urldecode($kd);
        $page = get_request_arg('p');
        $page = $page < 1 ? 1 : $page;
        $pagesize = 21;
        $pageindex = ($page - 1) * $pagesize;
        
        $videoModel = $this->modelFactory->get('video');
        $result = $videoModel->search($kd,$kd,$pageindex,$pagesize);
        $pagination = new Libs_Pagination($result['total'],$page,$pagesize);
        $pageHtml = $pagination->getPagination('/search/index/kd/'.urlencode($kd));
        
        $this->pushAssigns(array('videolist'=>$result['videos'],'pages'=>$pageHtml,'kd'=>$kd));
        $this->tpls = array('header.tpl','search.tpl','footer.tpl');
    }
}
?>
