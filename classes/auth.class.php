<?php
class Auth
{
    public function check()
    {
        if ( isset($_SESSION['uid']) && isset($_SESSION['email']) ) {
            if ( $_SESSION['uid'] != '' && $_SESSION['email'] != '' ) {
                return true;
            }
        }

        global $config;
        $_SESSION['redirect'] = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : $config['BASE_URL'];
        VRedirect::go($config['BASE_URL']. '/login');
    }

    static public function checkAdmin()
    {
        global $config;
        $access = false;
        if ( isset($_SESSION['AUID']) && isset($_SESSION['APASSWORD']) ) {
            if ( $_SESSION['AUID'] == $config['admin_name'] && $_SESSION['APASSWORD'] == $config['admin_pass'] ) {
                $access = true;
            }
            if (!empty($_SESSION['AUID']) && !empty($_SESSION['APASSWORD']) && !empty($_SESSION['ATYPE'])) {
                $access = true;
                $temp = array();
                $temp_str = '';
                $request_uri = $_SERVER['REQUEST_URI'];
                $request_uri_arr = explode('/', $request_uri);
                
                foreach ($request_uri_arr as $k=>$v){
                    if (empty($v) || $v == 'ajax') {
                        unset($request_uri_arr[$k]);
                    }else{
                        $temp_str = $v;
                    }
                }
                
                $http_host = $_SERVER['HTTP_ORIGIN'];
                $http_referer = $_SERVER['HTTP_REFERER'];
                $start_str = $http_host.'/siteadmin/';
                
                $length = strlen($http_referer);
                $start = strlen($start_str);
                $http_referer_filename = substr($http_referer, $start, $length-1);
                $filename = explode('.', $http_referer_filename);
                
                $m = 'all';
                if(isset($_REQUEST['m']))
                    $m = trim($_REQUEST['m']);
                $key = "{$filename[0]}.{$m}.{$temp_str}";
                
                $stype = $_SESSION['ATYPE'];
                $menu_actions = $config['perm_'.$stype.'_submenus'];
                $menu_actions = json_decode($menu_actions);
                
                if (strpos($request_uri,'ajax') !== false && !in_array($key, $menu_actions)) {
                    $response['flag'] = -1;
                    echo json_encode($response);
                    exit;
                }
            }
        }
       
        if ( !$access ) {
            VRedirect::go($config['BASE_URL']. '/siteadmin/login.php');
        }
    }

    public function confirm()
    {
        global $config;

        if ( $config['email_verification'] == '0' ) {
            return true;
        }

        if ( isset($_SESSION['uid']) && isset($_SESSION['email']) ) {
            if ( isset($_SESSION['emailverified']) && $_SESSION['emailverified'] == 'yes' ) {
                return true;
            }
        }

        $_SESSION['redirect'] = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : $config['BASE_URL'];
        VRedirect::go($config['BASE_URL']. '/confirm');
    }
}
?>
