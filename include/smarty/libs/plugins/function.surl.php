<?php
function smarty_function_surl($params, &$smarty){
    global $isMakeHtml;
    if ($isMakeHtml == 1 && is_array($params)) {
        return '/' . $params['dir'] . '/' . $params['val'] .'/' . $params['file'];
    }
    return '';
}