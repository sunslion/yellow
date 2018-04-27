<?php
defined('_VALID') or die('Restricted Access!');
class Novel extends Base{
    public function onIndex(){
        $pchid = 6;
        $chid = get_request_arg('cid');
        $page = get_request_arg('p');
        $page = $page > 0 ? $page : 1;
        //获取小说类别
        $novelChannels = $this->getChannels($pchid);
        $key = 'nnovel_'.$chid.'_'.$page;
        $output = $this->cache->get($key);
        if (!$output['novellist']) {
            $pagesize = 10;
            $where = '';
            $url = '/novel/index';
            if ($chid > 0) {
                $where = 'WHERE category_id ='.$chid;
                $url = '/novel/index/cid/'.$chid;
            }else{
                $chids = array();
                foreach ($novelChannels as $v) {
                    $chids[] = $v['CHID'];
                }
                if (count($chids) > 0) {
                    $where = 'WHERE category_id in ('.implode(',', $chids).')';
                }
            }
            $novelModel = $this->modelFactory->get('novel');
            $total = $novelModel->getTotal($where);
            $pagin = new Libs_Pagination($total,$page,$pagesize);
            $pages = $pagin->getPagination($url);
            $pageindex = ($page - 1) * $pagesize;
            $novelList = $novelModel->getAll($where,$pageindex,$pagesize);
            if (is_array($novelList) && !empty($novelList)) {
                foreach ($novelList as &$v) {
                    foreach ($novelChannels as $sv) {
                        if ($v['category_id'] == $sv['CHID']) {
                            $v['cname'] = $sv['name'];
                        }
                    }
                }
            }
            $output = array('pages'=>$pages,'novellist'=>$novelList);
            $this->cache->set($key,$output,3600);
        }
        $seo = array(
            'title'=>$this->conf['site_title'],
            'keyword'=>$this->conf['meta_keywords'],
            'description'=>$this->conf['meta_description'],
        );
        $this->pushAssigns($seo);
        $this->pushAssigns(array('novelchannels'=>$novelChannels,'chid'=>$chid,'pages'=>$output['pages'],'novellist'=>$output['novellist'],'CHID'=>$pchid));
        $this->tpls = array('header.tpl','novels.tpl','footer.tpl');
    }
    public function onShow(){
        $pchid = 6;
        $id = get_request_arg('id');
        $novelChannels = $this->getChannels($pchid);
        $novelModel = $this->modelFactory->get('novel');
        $novels = $novelModel->getAll('VID='.$id,0,1);
        $output = array();
        if ($novels && isset($novels[0])) {
            $output['novel'] = $novels[0];
            foreach ($novelChannels as $v) {
                if ($v['CHID'] == $novels[0]['category_id']) {
                    $output['cname'] = $v['name'];
                    break;
                }
            }
            $novelModel->updateViewNumber($id);
        }
        $title = '';
        $keyword = '';
        $des = '';
        if(isset($output['novel']) && isset($output['novel']['title']) && !empty($output['novel']['title'])) {
            $title = $output['novel']['title'].'-'.$this->conf['site_title'];
        }else{
            $title = $this->conf['site_title'];
        }
        if (isset($output['novel']) && isset($output['novel']['keyword']) && !empty($output['novel']['keyword'])) {
            $keyword = $this->conf['meta_keywords'].','.$output['novel']['keyword'];
        }else{
            $keyword = $this->conf['meta_keywords'];
        }
        if (isset($output['novel']) && isset($output['novel']['content']) && !empty($output['novel']['content'])) { 
            $des = $output['novel']['content'];
            $des = strip_tags($des);
            $des = insert_cleanandtrim_content(array('content'=>$des,'len'=>150));
        }else{
            $des = $this->conf['meta_description'];
        }
        $seo = array(
            'title'=>$title,
            'keyword'=>$keyword,
            'description'=>$des,
            'CHID'=>$pchid
        );
        $this->pushAssigns($seo);
        $this->pushAssigns($output);
        $this->tpls = array('header.tpl','novel.tpl','footer.tpl');
    }
}