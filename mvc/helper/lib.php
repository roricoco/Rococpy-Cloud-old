<?php 

	$sample_name = session_name("session");
    session_set_cookie_params(0, "/", "rococpy.com");
	session_start();

	date_default_timezone_set("Asia/Seoul");

	define("USER", @$_SESSION['user']);
	define("ROOT", $_SERVER['DOCUMENT_ROOT']);
	define("FILE_ROOT", str_replace("/cloud", "", $_SERVER['DOCUMENT_ROOT']));
	
	function dd() { 
		echo "<pre>"; 
			var_dump(...func_get_args());
		echo "</pre>";
	}

	function move($url, $msg = false) {
		if (is_array($msg)) {
			$msg = implode("\\n", $msg);
		}

		if ($msg) {
			echo "<script>alert('$msg')</script>";
		}

		$url = $url == "back" ? "history.back()" : "location.href='$url'";

		echo "<script>$url</script>";
		exit;
	}

	function view_data($loc, $data = []) {
		extract($data);

		require ROOT."/mvc/view/$loc.php";
	}

	function view($loc, $data = []) {
		extract($data);

		require ROOT."/mvc/view/cloud/header.php";
		require ROOT."/mvc/view/cloud/$loc.php";
		require ROOT."/mvc/view/cloud/footer.php"; 
	}

	function err($err, $url, $msg = false) {
		if ($err) {
			move($url, $msg);
		}
	}

	function arr($a) {
		return is_array($a) ? $a : [$a];
	}

	function unslash($s) {
		return str_replace("/\\/g", "", $s);
	}

	function validator($post, $arr = []) { 
		return array_filter($arr, function($v, $k) {
			return trim($post[$k]) == "";
		}, ARRAY_FILTER_USE_BOTH);
	}

	function img_up($img) {
		$micro = microtime();
		$fn = md5($micro.$img["name"]);

		$ext = pathinfo($img['name'], PATHINFO_EXTENSION);

		move_uploaded_file($img['tmp_name'], ROOT."/resources/uploaded/$fn.$ext");

		return "/resources/uploaded/$fn.$ext";
	}

	function responseJSON($json) {
		header("Content-Type: application/json");
		echo json_encode($json);
	}

	function gview($loc, $data = []) {
		extract($data);

		require ROOT."/mvc/view/guest/$loc.php";
	}

	function formatSize($bytes, $decimals = 2) {
        $size = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    function getBrowser() {
	    $broswerList = array('MSIE', 'Chrome', 'Firefox', 'iPhone', 'iPad', 'Android', 'PPC', 'Safari', 'Trident', 'none');
	    $browserName = 'none';
	    
	    foreach ($broswerList as $userBrowser){
	        if($userBrowser === 'none') break;
	        if(strpos($_SERVER['HTTP_USER_AGENT'], $userBrowser)) {
	            $browserName = $userBrowser;
	            break;
	        }
	    }
	    return $browserName;
	}
 
	function isBlockBrowser() {
	    $BrowserName = getBrowser();
	    if($BrowserName === 'MSIE'||$BrowserName === 'Trident'){
	        echo("죄송합니다. Internet Explorer를 통한 접속은 차단하고 있습니다. <br><a href='https://www.microsoft.com/ko-kr/edge'>New Edge</a>, <a href='https://www.google.com/intl/ko/chrome/'>Chrome</a>또는 <a href='https://www.mozilla.org/ko/firefox/new/'>FireFox</a> 등 차세대 브라우저를 이용해주십시오."); 
	        die;
	    }
	}

	function login() { 
		$rurl = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("Location:https://account.rococpy.com/login?redirect=".$rurl);
	}

	function linecess() { 
		view("linecess");
	}

	function files_format($data){
		foreach ($data as $key => $value) {
			foreach ($value as $key1 => $value1) {
				$redata[$key1][$key] = $value1;
			}
		}
		return $redata;
	}



 ?>