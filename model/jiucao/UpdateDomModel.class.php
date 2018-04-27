<?php
defined('_VALID') or die('Restricted Access!');
class UpdateDomModel extends BaseModel
{
    public function getAll() { 
        //$where = " limit 1000";
        $sql = "SELECT `VID`,`ipod_filename`,`pic` FROM video ".$where;
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0) {
            $rows = $rs->getrows();
            $result = array();
            foreach ($rows as $key => $v) {
                //$result[$key]['ipod_filename'] = $v['ipod_filename'];
                $result[$key]['VID'] = $v['VID'];
                $re_ipod_filename = str_ireplace('video88.lsb28.com','video.jiagew762.com',$v['ipod_filename']);
                $re_pic = str_ireplace('video88.lsb28.com','video.jiagew762.com',$v['pic']);
                $re_ipod_filename ? $result[$key]['re_ipod_filename'] =  $re_ipod_filename : $result[$key]['re_ipod_filename'] = $v['ipod_filename'];
                $re_pic ? $result[$key]['re_pic'] =  $re_pic : $result[$key]['re_pic'] = $v['pic'];
            }
        }
        $Total = count($result);
        //print_r($result);
        //exit($result);
        $i=0;
        //----批量更新数据库
        if(is_array($result)&&implode('',$result)){
            $countI = 0;
            foreach ($result as $k2 => $v2) {
                if(!$v2['VID']) continue; //判断主键ID不能为空
                //1000条数据停止2s
                if($countI==1000){
                    sleep(2);
                    $countI=0;
                    //exit;
                }
                $v2['re_ipod_filename']?$ipod_filename= $v2['re_ipod_filename']:$ipod_filename= '';
                $v2['re_pic']?$pic= $v2['re_pic']:$pic= '';
                //$pic="http://video88.lsb28.com:8091/20170717/W6l3C78O/".$i.'.jpg';
                $sql2 = " UPDATE `video` SET `ipod_filename`='{$ipod_filename}',`pic`='{$pic}' WHERE `VID`=".$v2['VID'];
                //echo $sql2;
                $rs2 = $this->conn->Execute($sql2);
                $countI++;
                $i++;
            }
        }
        return "修改域名完毕！已修改 :".$i."条数据！---总共存在：".$Total."数据";
        //echo "修改域名完毕！已修改 :".$i."条数据！";
        //$str = 'http://video88.lsb28.com:8091/20171003/ibnboqMi/index.m3u8';
        //测试replace_into
        //$sql2 = "REPLACE INTO `video`(`VID`,`ipod_filename`)VALUES(15138,'{$str}')";
        //echo $sql2;
        //var_dump($result);
        //$str = 'http://video88.lsb28.com:8091/20171003/ibnboqMi/index.m3u8';
        //$repStr = str_ireplace('video88.lsb28.com','video.jiagew762.com',$str);
        // /var_dump($repStr);
        //var_dump($result);
    }
 
}
?>