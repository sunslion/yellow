<?php
defined('_VALID') or die('Restricted Access!');
class Picture extends Base{
    public function onIndex() {
        $pchid = 7;
        $chid = get_request_arg('cid');
        $page = get_request_arg('p');
        $page = $page > 0 ? $page : 1;
        $pagesize = 20;
        $pageindex = ($page - 1) * $pagesize;
        //获取小说类别
        $pictureChannels = $this->getChannels($pchid);
        
        $key = 'npicture_'.$chid.'_'.$page;
        $output = $this->cache->get($key);
        if (!$output['picturelist']) {
            $where = '';
            $url = '/picture/index';
            if($chid > 0){
                $where = 'category_id = '.$chid;
                $url .= '/cid/'.$chid; 
            }else{
                $chids = array();
                foreach ($pictureChannels as $v) {
                    $chids[] = $v['CHID'];
                }
                if (count($chids) > 0) {
                    $where = 'category_id in ('.implode(',', $chids).')';
                }
            }
            $pictureModel = $this->modelFactory->get('picture');
            $total = $pictureModel -> getTotal($where);
            $pagination = new Libs_Pagination($total,$page,$pagesize);
            $output['pages'] = $pagination->getPagination($url);
            
            $pageindex = ($page - 1) * $pagesize;
            $output['picturelist'] = $pictureModel->getAll($where,$pageindex,$pagesize);
            if (is_array($output['picturelist']) && !empty($output['picturelist'])) {
                foreach ($output['picturelist'] as &$v) {
                    foreach ($pictureChannels as $sv) {
                        if ($v['category_id'] == $sv['CHID']) {
                            $v['cname'] = $sv['name'];
                        }
                    }
                }
            }

            $this->cache->set($key,$output,3600);
        }
        $seo = array(
            'title'=>$this->conf['site_title'],
            'keyword'=>$this->conf['meta_keywords'],
            'description'=>$this->conf['meta_description'],
        );
        $this->pushAssigns($seo);
        $this->pushAssigns(array('picturechannels'=>$pictureChannels,'chid'=>$chid,'pages'=>$output['pages'],'picturelist'=>$output['picturelist'],'CHID'=>$pchid));
        $this->tpls = array('header.tpl','pictures.tpl','footer.tpl');
    }
    public function onShow(){
        $pchid = 7;
        $id = get_request_arg('id');
        
        $pictureModel = $this->modelFactory->get('picture');
        $pictures = $pictureModel->getAll('VID='.$id,0,1);
        $options = array();
        if ($pictures && isset($pictures[0])) {
            $options['picture'] = $pictures[0];
            $channels = $this->getChannels($pchid);
            foreach ($channels as $v) {
                if ($v['CHID'] == $pictures[0]['category_id']) {
                    $options['cname'] = $v['name'];
                    break;
                }
            }
            $pictureModel->updateviewNumber($id);
        }
        $title = '';
        $keyword = '';
        $des = '';
        if(isset($options['picture']) && isset($options['picture']['title']) && !empty($options['picture']['title'])) {
            $title = $options['picture']['title'].'-'.$this->conf['site_title'];
        }else{
            $title = $this->conf['site_title'];
        }
        if (isset($options['picture']) && isset($options['picture']['keyword']) && !empty($options['picture']['keyword'])) {
            $keyword = $this->conf['meta_keywords'].','.$options['picture']['keyword'];
        }else{
            $keyword = $this->conf['meta_keywords'];
        }
        if (isset($options['picture']) && isset($options['picture']['des']) && !empty($options['picture']['des'])) {
            $des = $options['picture']['des'];
        }else{
            $des = $this->conf['meta_description'];
        }
        $seo = array(
            'title'=>$title,
            'keyword'=>$keyword,
            'description'=>$des,
            'CHID'=>$pchid
        );
        $this->pushAssigns($options);
        $this->pushAssigns($seo);
        $this->tpls = array('header.tpl','picture.tpl','footer.tpl');
    }
}
