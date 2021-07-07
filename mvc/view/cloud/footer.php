<div class="sidenav-overlay"></div>

      <style>
        .sidenav-overlay, .modal, .sidenav, .modal-overlay {
          transition:0.3s all;
        }
  
        .modal, .modal-overlay{
          opacity:0;
        }
        
        .modal{
          top:4%;
          z-index:1003;
          transform: scale(0.8);
        }
		@keyframes rotation {
		  from {transform: rotate(359deg);}
		  to   {transform: rotate(0deg);}
		}

		@keyframes load {
		  0% {transform: scale(0.7);}
		  100%   {transform: scale(1);}
		}

		.ctoast{
			position: fixed;
			bottom: 20px;
			right: 20px;
		}
		.uploading{
			margin-top: 20px;
			width: 300px;
			height: 100px;
			background: white;
			box-shadow: 0 0 13px black;
			color: white;
		}

		.uploadingtop{
			background: black;
			width: 100%;
			height: 50px;
			display: flex; 
			align-items: center;
			padding: 0 5px;
		}
		.uploadingtop p{
			margin-left: 5px;
		}

		.uploadingtop > .material-icons{
			position: relative;
		}

		.absolute-ico{
			position: absolute;
			left: 3px;
			top: 4px;
			color: black!important;
			font-size: 18px;
			animation: rotation 2s infinite linear;
		}

		.uploadingbtn{
			display: flex;
			align-items: center;
			justify-content: center;
			height: 50px;
		}

		.progressbar{
			height: 25px;
			width: 90%;
			position: relative;
		}

		.progressbar:hover .size{ opacity: 1; }
		.progressbar:hover .per{ opacity: 0; }
		.nowupload, .totaluplaod{ font-weight: inherit; }

		.per{
			color: black;
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			transition: 0.3s opacity;
			opacity: 1;
		}

		.size{
			text-align: center;
			color: black;
			transition: 0.3s opacity;
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			opacity: 0;
			width: 100%;
		}

		.bars{
			background: #66c4ff;
			height: 100%;
			width: 0%;

		}

		.loading{
			visibility: visible;
			opacity: 1;
			transition: 0.2s all;
			position:fixed;
			top:0;
			left:0;
			width:100%;
			height:100%;
			background:rgba(0, 0, 0, 0.5);
			z-index:60000;
			display:flex;
			align-items:center;
			justify-content:center;
		}

		.loading img{
			max-width: 200px;
			max-height: 200px;
			width: 100%;
			height: 100%;
			animation: load 0.5s infinite alternate;
		}
	</style>

	<div class="ctoast">
		
	</div>
		<div class="loading">
		<img src="https://cdn.rococpy.com/other_img/logo.png" alt="load">
		</div>

	
	<!-- footer -->
	<footer class="page-footer blue lighten-2">
		<!-- container -->
		<div class="container">
			<div class="row">
				<div class="col m12">
					<h5 class="white-text">Contact</h5>
					<ul>
						<li><del><a class="grey-text text-lighten-3" href="mailto:roricoco@rococpy.com">roricoco@rococpy.com</a></del></li>
						<li><a class="grey-text text-lighten-3">김주희#2729 / 비상식량 설화몬#5262</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container">
				<span class="left">Copyright 2019 - 2021 Rococpy All rights reserved.</span>
			</div>
		</div>
		<!-- container -->
	</footer>
	<!-- footer -->

	<!-- side navigation -->
	<ul id="sidenav" class="sidenav">
		<li>
			<div class="user-view">
				<div class="background">
					<img src="/assets/cloud/images/user-back.png">
				</div>
				<a href="#user"><img class="circle" src="/assets/cloud/images/user.png"></a>
				<a href="#name"><span class="white-text name"><?php if (USER) {
					echo USER['name'];
				}else{
					echo "Guest";
				} ?></span></a>
				<a href="#email"><span class="white-text email"><?php if (USER) {
					echo USER['id'];
				} ?></span></a>
			</div>
		</li>
		<li>
			<a href="https://www.rococpy.com" class="modal-trigger not">Main Site</a>
		</li>
		<?php if (USER) : ?>
		<li>
			<a href="#lang" class="modal-trigger not"><i class="material-icons">language</i>Language</a>
		</li>
			<?php if ($dark['dark']=="0"): ?>
				<li>
					<a href="#" class="not changecolor"><i class="material-icons">brightness_4</i>Switch Dark Mode</a>
				</li>
			<?php else: ?>
				<li>
					<a href="#" class="not changecolor"><i class="material-icons">brightness_7</i>Switch Dark Mode</a>
				</li>
			<?php endif ?>
			<li>
				<a class="not dnt_mv_t_mv" href="/"><i class="material-icons">cloud</i>My Cloud</a>
			</li>
			<li>
				<a class="not dnt_mv_t_mv" href="/trash"><i class="material-icons">delete</i>Trash File</a>
			</li>
			<li>
				<a href="https://account.rococpy.com/logout" onclick="return confirm('<?= $lang_logout ?>')" class="modal-trigger not"><i class="material-icons">lock_open</i>Logout</a>
			</li>
		<?php endif ?>

	</ul>
	<!-- side navigation -->

	<div id="lang" class="modal">
		<div class="modal-content">
			<h4>Language</h4>
			<p>&nbsp;</p>
			<div class="input-field">
				<a href="#" class="kor">한국어</a>
			</div>
			<div class="input-field">
				<a href="#" class="eng">English</a>
			</div>
			<div class="input-field">
				<a href="#" class="ja">日本語</a>
			</div>
		</div>
	</div>
	<!-- new project form -->

	


</body>
</html>