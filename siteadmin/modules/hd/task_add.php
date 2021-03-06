<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
require $config['BASE_DIR'].'/include/config.rank.php';
if (isset($_POST['add_task'])) {
    require $config['BASE_DIR'].'/classes/Games_task.class.php';
    $filter = new VFilter();
    $tname = $filter->get('tname');
    $condition = $_POST['task'];
    $condition = json_encode($condition);
    $prize = $filter->get('prize');
    $isshow = $filter->get('isshow');
    $order = $filter->get('order');
    if(Games_task::add($tname, $condition, $prize,$isshow,$order)){
        $messages[] = '数据添加成功';
    }else{
        $errors[] = '数据添加失败';
    }
}
$smarty->assign('task_type', $task_type);
$smarty->assign('task_type_json', '['.json_encode($task_type).']');
$smarty->assign('task_sign', $task_sign);
$smarty->assign('task_sign_json', '['.json_encode($task_sign).']');
$smarty->assign('task_join', $task_join);
$smarty->assign('task_join_json', '['.json_encode($task_join).']');