<!DOCTYPE HTML>
<!--
	Identity by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Copyright Rococpy</title>
		<style>.fa-down {
    content: "\f0c2"
}</style>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="/assets/guest/css/main.css" />
		<link rel="stylesheet" href="/assets/guest/css/fontawesome-all.min.css" />
		<noscript><link rel="stylesheet" href="/assets/guest/css/noscript.css" /></noscript>
		<script src="https://cdn.rococpy.com/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdn.rococpy.com/js/right_click.js"></script>
	</head>
	<script>const urls = [
    ["메인페이지", "https://www.rococpy.com"],
    ["클라우드", "https://cloud.rococpy.com"],
    ["URL 줄이기", "https://url.rococpy.com"]
]
</script>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<section id="main">
						<header>
							<h1><?=$file['filename']?></h1>
							<p>업로더 : <?= $name['name'] ?><br>파일크기 : <?= formatSize(filesize(".".$file['savename']));?><br>업로드일 : <?= $file['date'] ?><br>남은 다운로드 공유 횟수 : <?php if ($file['share_life']==-1) : ?>무제한<?php else : ?><?= $file['share_life']?> 회<?php endif ?></p>
						</header>
						<footer>
							<ul class="icons">
      							<a href="/download/<?=$file['idx']?>/share">Download</a>
							</ul>
						</footer>
					</section>

				<!-- Footer -->
					<footer id="footer">
						<ul class="copyright">
							<li>&copy; Copyright Rococpy</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</footer>

			</div>

		<!-- Scripts -->
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-preload\b/, ''); });
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}
			</script>

	</body>
</html>
