<?php

//require 'common.php';
/*
$filename = 'D:\applicaction\jiucao/a.csv';
$fb = fopen($filename, 'rb');
$sqls = array();
$sql = "DELETE FROM video WHERE locate('%s',ipod_filename)>0;\n";
while (!feof($fb)){
    $s = fgets($fb);
    $s = str_replace(array(" ","\r\n","\r","\n","\t"), '', $s);
    $sqls[] = sprintf($sql,$s);
}
fclose($fb);
$str = implode('', $sqls);
file_put_contents('clear.sql', $str);
exit;*/
/*
        $sql = 'SELECT VID,title,channel,pic,ipod_filename,keyword FROM video WHERE VID in (9224,9225,9226,9227,9228,9229,9231,9232,9233,9234,9236,9237,9238,9239,9241,9242,9243,9245,9246,9247,9249,9250,9251,9252,9256,9257,9258,9259,9261,9262,9263,9264,9266,9267,9268,9270,9271,9272,9274,9275,9276,9277,9279,9280,9281,9282,9284,9285)';
        $rs             = $conn->execute($sql);var_dump($rs);
        if($rs && $conn->Affected_Rows() > 0){
            $rows = $rs->getrows();
            $path = $config['BASE_DIR'] . '/cache/syn/add';
            if (!file_exists($path)) {
                mkdir($path,0777,true);
            }
            foreach ($rows as $k=>$v) {
                $fileName = $path.'/add_'.$k.time().'.txt';
                $data = array(
                    'm_id'=>$v['VID'],
                    'm_name'=>$v['title'],
                    'm_type'=>$v['channel'],
                    'm_pic'=>$v['pic'],
                    'm_playdata'=>$v['ipod_filename'],
                    'm_keyword'=>$v['keyword']
                );
                if (file_exists($path)) {
                    file_put_contents($fileName,json_encode($data));
                }
            }

        }
        */
   var_dump( class_exists('Memcache') );
   $men = new Memcache();
   $men->connect('127.0.0.1',11211);
   $men->set('bb','abcd');
   var_dump($men->get('bb'));
