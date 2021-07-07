<?php 

    if (USER) $dark = DB::mq("SELECT * FROM cloud WHERE useridx=?",[USER['idx']])->fetch();

	$version = "4.0.17";
    $updated = "2021-05-20 Thu";
    error_reporting(0);
    include "locale/".$dark['language'].".php";
    error_reporting(1);

?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <?php if (@$dark['dark']=="1") {
        echo '<link rel="stylesheet" id="dark_csses" type="text/css" href="/assets/cloud/css/dark.css">';
    } ?>
	<meta charset="UTF-8">
	<title>Cloud Manager</title>
	<link rel="icon" href="https://cdn.rococpy.com/others/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="https://cdn.rococpy.com/others/favicon.ico" type="image/x-icon"/>
    <meta name="naver-site-verification" content="5a61e7e45133cb9a5c5ed14e9a2b12dd9740e107"/>
	<meta name="google-site-verification" content="EXVsivdubCCAG_nfRWFM5IqDTQmVrrpFMOnwxDIfIKk" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.rococpy.com/materialize/css/materialize_custom.css">
	<link rel="stylesheet" type="text/css" href="/assets/cloud/css/style.css">
	<script type="text/javascript" src="https://cdn.rococpy.com/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.rococpy.com/jquery-form/4.3.0/jquery.form.min.js"></script>
	<!-- <script type="text/javascript" src="https://cdn.rococpy.com/materialize/js/materialize.min.js"></script> -->
	<script type="text/javascript" src="/assets/cloud/js/custommaterial.js"></script>
	<!-- Channel Plugin Scripts -->
	<!-- <script>
	  (function() {
	    var w = window;
	    if (w.ChannelIO) {
	      return (window.console.error || window.console.log || function(){})('ChannelIO script included twice.');
	    }
	    var ch = function() {
	      ch.c(arguments);
	    };
	    ch.q = [];
	    ch.c = function(args) {
	      ch.q.push(args);
	    };
	    w.ChannelIO = ch;
	    function l() {
	      if (w.ChannelIOInitialized) {
	        return;
	      }
	      w.ChannelIOInitialized = true;
	      var s = document.createElement('script');
	      s.type = 'text/javascript';
	      s.async = true;
	      s.src = 'https://cdn.channel.io/plugin/ch-plugin-web.js';
	      s.charset = 'UTF-8';
	      var x = document.getElementsByTagName('script')[0];
	      x.parentNode.insertBefore(s, x);
	    }
	    if (document.readyState === 'complete') {
	      l();
	    } else if (window.attachEvent) {
	      window.attachEvent('onload', l);
	    } else {
	      window.addEventListener('DOMContentLoaded', l, false);
	      window.addEventListener('load', l, false);
	    }
	  })();
	  ChannelIO('boot', {
	    "pluginKey": "9cd090e2-2d08-446c-9d86-4247ad1f1edf"
	  });
	</script>
	End Channel Plugin -->

	<meta name="description" content="RocoCompany 공식 클라우드입니다.">
  <link rel="canonical" href="https://cloud.rococpy.com">
  <meta property="og:type" content="website"> 
	<meta property="og:title" content="RocoCompany Cloud">
	<meta property="og:description" content="RocoCompany 공식 클라우드입니다.">
	<meta property="og:url" content="https://cloud.rococpy.com">
	<script src="https://cdn.rococpy.com/js/right_click.js"></script>
	<script> const urls = [
		["통합 페이지", "https://www.rococpy.com"],
		["매인 페이지", "https://cloud.rococpy.com"],
		["URL 줄이기", "https://url.rococpy.com"]
	]
	</script>
</head>
<body class="blue-grey lighten-5 bodyload" id="bodyload">
	<?php if (isset($lang_alert)) : ?>
		<div style="display: flex; justify-content: center;"><i style="color:black!important; margin-right: 2px" class="material-icons">error</i><b><?= $lang_alert ?></b></div>
	<?php endif ?>

	<!-- header -->
	<nav class="blue lighten-2 header_nav">
		<!-- container -->
		<div class="container">
			<div class="nav-wrapper">

				<!-- title -->
				<a class="brand-logo center dnt_mv_t_mv" href="/"><i class="material-icons">cloud_queue</i>Cloud</a>

				<!-- menu icon -->
				<ul class="left">
					<li data-target="sidenav" class="sidenav-trigger">
						<a href="#" class="not"><i class="material-icons small">menu</i></a>
					</li>
				</ul>
			</div>
		</div>
		<!-- container -->
	</nav>
	<!-- header -->