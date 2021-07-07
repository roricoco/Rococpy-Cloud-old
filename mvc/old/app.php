<?php 

    use \model\_base as DB;

    $sample_name = session_name("session");
    session_set_cookie_params(0, "/", "rococpy.com");
    session_start();

    date_default_timezone_set("Asia/Seoul");
    
    define("ROOT", $_SERVER['DOCUMENT_ROOT']);
    define("USER", @$_SESSION['user']);
    
    spl_autoload_register(function($cn) {
        if (file_exists($f = __DIR__."/$cn.php")) {
            require __DIR__."/$cn.php";
        }
        else {
        	error_reporting(0);
        	require __DIR__."/view/main/404.php";
        	die;
        }
    });
    
    function dd(...$val) {
        echo "<pre>";
            array_map("var_dump", $val);
        echo "</pre>";
    }
    
    function tcview($loc, $data = []) {
        extract($data);
        
        require_once __DIR__."/view/cloud/header.php";
        require_once __DIR__."/view/cloud/$loc.php";
        require_once __DIR__."/view/cloud/footer.php";
    }
    
    function gview($loc, $data = []) {
        extract($data);
        
        require_once __DIR__."/view/guest/$loc.php";
    }

    function move($loc, $msg = []) {
        if ($msg) {
            echo "<script>alert('$msg')</script>";
        }
        if ($loc) {
            echo "<script>location.href='$loc'</script>";
        }
        else {
            echo "<script>history.back()</script>";
        }
    }
       
    function formatSize($bytes, $decimals = 2) {
        $size = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    $log['ip'] = $_SERVER["REMOTE_ADDR"];
    $log['url'] = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $log['port'] = $_SERVER['REMOTE_PORT'];
    $log['clant'] = $_SERVER['HTTP_USER_AGENT'];
    $log['method'] = $_SERVER['REQUEST_METHOD'];
    $log['access'] = $_SERVER['REDIRECT_STATUS'] ?? "unknown";
    $log['session'] = $_SESSION['user']['id'] ?? "guest";
    $log['protocol'] = $_SERVER['SERVER_PROTOCOL'];
    $log['post'] = json_encode($_POST);
    DB::insert("log", $log);


    $url = explode("/", $_GET['url'] ?? "main");
    $cont = "Controller\\".array_shift($url)."Controller";
    $method = array_shift($url) ?? "index";
    
    $inst = new $cont;
    $inst->{$method}(...$url);
    
 ?>
