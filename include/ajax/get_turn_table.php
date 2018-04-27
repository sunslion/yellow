<?php
defined('_VALID') or die('Restricted Access!');
header("Content-type: text/json; charset=utf-8");
$prize_info = array('prize'=>0,'info'=>'您尚未登陆，不能参加抽奖!');
if (!isset($_SESSION['uid']) || intval($_SESSION['uid']) <= 0) {
    echo json_encode($prize_info);
    exit;
}
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
$options = array(
    'host'=>$config['mem_host'],
    'port'=>$config['mem_port'],
    'prefix'=>'prizes',
    'expire'=>0,
    'length'=>0
);
$cache = Cache::getInstance('MemcacheAction',$options);
$ip = GetRealIP();
$key = 'p'.$ip.$_SESSION['uid'];
$result = $cache->get($key);
if ($result) {
    $prize_info['prize'] = -1;
    $prize_info['info'] = '您今天已经参加过抽奖了';
    echo json_encode($prize_info);
    exit;
}
$prizes = array(
    1=>'喜中168个vip色币！存100立刻兑换',
    2=>'喜中腾讯视频月会员！存100立刻兑换',
    3=>'喜中爱奇艺月会员！存100立刻兑换',
    4=>'喜中10元话费！存100立刻兑换',
    5=>'喜中裸聊点100！存50立刻兑换',
    6=>'喜中88个VIP色币！存50立刻兑换',
    7=>'喜中2个vip色币体验！联系客服兑换',
    8=>'下个幸运星马上就是您了再接再厉明日再试哦！',
);
$prizes_probability = array(
  1=>'0.05',
  2=>'0.05',
  3=>'0.1',
  4=>'0.1',
  5=>'0.1',
  6=>'0.15',
  7=>'0.15',
  8=>'0.3',
);
$r = rand(1, 100);
$num = 0;
$award_id = 0;
foreach ($prizes as $k => $v) {
    $tmp = $num;
    $num += $prizes_probability[$k] * 100;
    if ($r > $tmp && $r <= $num) {
        $award_id = $k;
        break;
    }
}
$info = $prizes[$award_id];
$curtime = time();
$sql = "INSERT INTO prizes (ptype,prizes,info,ptime,uid,uname,ip) VALUES(0,{$award_id},'{$info}','{$curtime}',{$_SESSION['uid']},'{$_SESSION['username']}','{$ip}')";
$r = $conn->execute($sql);

$prize_info['prize'] = $award_id;
$prize_info['info'] = $info;


$today = strtotime(date('Y-m-d'));
$nextday = strtotime("+1 day",$today);
$expire = $nextday - $curtime;
$cache->set($key,$prize_info,$expire);
echo json_encode($prize_info);exit;