<?php
defined('_VALID') or die('Restricted Access!');
class GetSugetModel extends BaseModel
{
    //获取随机20条视频
    public function getSugetVideo($num=20){
        //获取最近7天视频
        $endTime = strtotime(date("Y-m-d",time()));//今天零点时间戳
        $startTime = $endTime-(6*24*3600);
        //获取随机的20条视频
        $sql = "SELECT count(VID) as total FROM `video`";
        $sql .= " WHERE `addtime` BETWEEN $startTime AND $endTime ";//推荐最近7天的视频
        $total =  $this->getNumInfo($sql,1);
        //获取所有视频
        $sql2 = "SELECT `VID`,`addtime`,`pic`,`title`,`viewnumber` FROM `video`";
        $sql2 .= " WHERE `addtime` BETWEEN $startTime AND $endTime ";//推荐最近7天的视频
        $allVideo = $this->getAll($sql2);
        //var_dump($sql2);
        //获取20条随机视频--判断存在视频数据
        if(is_array($total)&&$total[0]['total']&&is_array($allVideo)&&$allVideo[0]['VID']){
            $arr = array();
            $i = 0;
            while ($i<$num){
                if($total[0]['total']<=10) break;//如果视频总数小于10不推荐
                $temp = mt_rand(0,$total[0]['total']-1);
                if(!in_array($temp,$arr)){
                    $arr[] = $temp;
                    $i++;
                }
            }
        }
        $suggestVideo = array();
        //如果随机函数赋值成功
        if(is_array($arr)&&implode('',$arr)){
            foreach($arr as $k=>$v){
                $suggestVideo[$k]['pic'] = $allVideo[$v]['pic'];
                $suggestVideo[$k]['VID'] = $allVideo[$v]['VID'];
                $suggestVideo[$k]['title'] = $allVideo[$v]['title'];
                $suggestVideo[$k]['addtime'] = date('Y-m-d H:i:s',$allVideo[$v]['addtime']);
                $suggestVideo[$k]['viewnumber'] = $this->getViewNum($allVideo[$v]['viewnumber']);
                $suggestVideo[$k]['pic'] =  str_replace($this->get_domain($suggestVideo[$k]['pic']),$this->conf['img_domin'],$suggestVideo[$k]['pic']);//替换域名
            }
        }
        return $suggestVideo;
    }

    //获取视频观看数
    public function getViewNum($viewNum){
        $viewNum = intval($viewNum);
        $firstNum = mt_rand(10000,15000);//初始观看书
        $ratio = mt_rand(200,500); //真实观看数系数
        $lastViewNum = $firstNum+($ratio*$viewNum);
        return $lastViewNum;
    }
    //获取顶的数量
    public function getLike($viewNum,$likeNum){
        intval($viewNum)?$viewNum = intval($viewNum): $viewNum = 10000;
        $firstNum =intval((1/50)*$viewNum) ;//初始顶的数量
        intval($likeNum)?$likeNum = intval($likeNum): $likeNum = 1;//真实顶的数量
        $ratio = mt_rand(100,200); //顶的系数
        $lastViewNum = $firstNum+($ratio*$likeNum);
        return $lastViewNum;
    }
    //获取踩的数量
    public function getDislike($viewNum,$dislikeNum){
        intval($viewNum)?$viewNum = intval($viewNum): $viewNum = 10000;
        $firstNum = intval((1/100)*$viewNum);//初始踩的数量
        intval($dislikeNum)?$dislikeNum = intval($dislikeNum): $dislikeNum = 1;//真实踩的数量
        $ratio = mt_rand(50,100); //顶的系数
        $lastViewNum = $firstNum+($ratio*$dislikeNum);
        return $lastViewNum;
    }

    public function getAll($sql) {
        if(empty($sql)) return false;
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0){
            $rows = $rs->getrows();
        }else{
            $rows = array();
        }
        return $rows;
    }

    public function getNumInfo($sql,$n=1) {
        if(empty($sql)) return false;
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0){
            $rows = $rs->getrows($n);
        }else{
            $rows = array();
        }
        return $rows;
    }

    //获取字符串现在的域名
    public function get_domain($url){
        if(!$url||!strstr($url,'/',true)) return $url;
        $protocol= strstr($url,'/',true); //协议--http:
        $url = str_replace($protocol.'//','',$url); //url 去除协议
        $domin = strstr($url,'/',true);//域名
        $domin = trim($domin);
        return $domin;
    }

}
?>