
<!-- main section -->
	<section id="main">
		<div class="card manager-header">
			<div class="container">

				<div class="projecttitle"><?= USER['id'] ?>/Cloud</div>
				<p><?= $lang_welcome ?></p>

			</div>
			<div class="divider"></div>
			<div class="container">

				<ul class="tabs row">
					<li class="tab col"><a href="#code"><?= $lang_maintab1 ?></a></li>
					<li class="tab col"><a href="#version"><?= $lang_maintab2 ?></a></li>
					<li class="tab col"><a href="#compare"><?= $lang_maintab3 ?></a></li>
				</ul>

			</div>
		</div>
		<div class="container">

			<div id="code">
				<div class="card">

					<div class="btn_group">							
						<button class="waves-effect waves-light btn modal-trigger" href="#downloada"><i class="material-icons">file_download</i><?= $lang_download ?></button>
						<?php if($max>=$max_stroge) : ?><?php else:?><button class="waves-effect waves-light btn modal-trigger blue lighten-1" href="#form"><i class="material-icons">file_upload</i><?= $lang_upload ?></button><?php endif?>
						<button class="waves-effect waves-light btn modal-trigger right red lighten-1" href="#Abandon"><i class="material-icons" style="margin:0!important">delete</i></button>
					</div>

					<div class="divider"></div>
						<div id="main_list_cloud" class="collection tab-content">
							<a class="collection-item dnt_mv_t_mv" href="/trash"><i class="material-icons">delete</i><?= $lang_trash ?></a>
							<?php foreach ($list as $key => $value) : ?>
								<?php $ext = substr(strrchr($value['savename'], '.'), 1); ?>
								<a class="collection-item dnt_mv_t_mv" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis" href="/view/<?= $value['idx'] ?>">
									<i class="material-icons">
										<?php require "check.php" ?>
									</i><?= $value['filename'] ?>
								</a>
							<?php endforeach ?>
						</div>
				</div>
			</div>

			<div id="version">
				<div class="card">

					<div class="collection tab-content">
						<div class="collection-item">
							<a class="title"><?= $lang_plan ?></a>
							<a class="right modal-trigger" href="#upgrade">Upgrade</a>
							<?php if ($max_stroge=="32210000000") : ?>
								<div>Use Free Plan(<?= formatSize($max_stroge) ?>)</div>
							<?php elseif ($max_stroge=="64420000000") : ?>
								<div>Use Basic Plan(<?= formatSize($max_stroge) ?>)</div>
							<?php elseif ($max_stroge=="107370000000") : ?>
								<div>Use Pro Plan(<?= formatSize($max_stroge) ?>)</div>
							<?php elseif ($max_stroge=="322120000000") : ?>
								<div>Use Premium Plan(<?= formatSize($max_stroge) ?>)</div>
							<?php elseif ($max_stroge=="1100000000000") : ?>
								<div>Use Enterprise Plan(<?= formatSize($max_stroge) ?>)</div>
							<?php else : ?>
								<div>Use Other Plan(<?= formatSize($max_stroge) ?>)</div>
							<?php endif ?>
						</div>
						<div class="collection-item">
							<a class="title"><?= $lang_use ?></a>
								<div <?= $max/$max_stroge*100>=100 ? 'style="color:red;"' : ($max/$max_stroge*100>80 ? 'style="color:orange;"' : "") ?>>
									<?= formatSize($max) ?>/<?= formatSize($max_stroge) ?> (<?= ceil( $max/$max_stroge*100 )?>%)<?= $max/$max_stroge*100>=100 ?'<sup><?= $lang_maxwarn ?></sup>' : "" ?></div>
						</div>
						<div class="collection-item">
							<a class="title"><?= $lang_ckagree ?></a>
							<a class="right modal-trigger" href="#unreg"><?= $lang_userunreg ?></a>
							<div><?= $lang_agree ?></div>
						</div>
						<div class="collection-item account_info_last">
							<a class="title"><?= $lang_uploadt ?></a>
							<div><?= $count ?><?= $lang_countmlk ?><sub> <?= $lang_intrash ?><?= $lang_countmlk ?></sub></div>
						</div>
					</div>

				</div>
			</div>

			<div id="compare">
				<div class="card">
					<div class="collection tab-content">
						<div class="collection-item">
							<a class="title"><?= $lang_cloudver ?></a>
							<div><?= $version ?></div>
						</div>
						<div class="collection-item">
							<a class="title"><?= $lang_lastud ?></a>
							<div><?= $updated ?></div>
						</div>
						<div class="collection-item">
							<a class="title"><?= $lang_stats ?></a>
							<div><?= $lang_stabil ?> | <?= $lang_fast ?></div>
						</div>
						<div class="collection-item">
							<a class="title"><?= $lang_devlope ?></a>
							<div><?= $lang_developer ?></div>
						</div>
						<div class="collection-item">
							<a class="title"><?= $lang_engine ?></a>
							<div>Materialize Css, Rco Custom Materialize Js</div>
						</div>
					</div>
				</div>
			</div>
			<!-- tab contents -->
		</div>
		<form id="form" class="modal" action="/upload" method="POST" enctype="multipart/form-data">
		<div class="modal-content">
			<h4><?= $lang_upload ?></h4>
			<p>&nbsp;</p>
			<div class="file-field input-field">
				<div class="btn">
					<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;File&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<input id="files" type="file" name="upload[]" style="height: 45px;" required multiple="">
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate"  type="text">
				</div>
				<div class="input-field">
					<input type="text" id="Note" name="note" autocomplete="off">
					<label for="Note">Note</label>
				</div>
			</div>
		</div>
		<div class="modal-footer input-field">
			<button type="reset" class="modal-action waves-effect waves-green btn-flat"><?= $lang_reset ?></button>
			<button type="submit" class="modal-action waves-effect waves-green btn-flat"><?= $lang_upload ?></button>
		</div>
	</form>
	<!-- upload form -->

	<!-- delete form -->
	<form id="Abandon" class="modal" action="/Abandon" method="POST">
		<div class="modal-content">
			<h4><?= $lang_delete ?></h4>
			<p>&nbsp;</p>
			<div class="collection tab-content" style="overflow: auto">
				<?php foreach ($list as $key => $value) : ?>
					<?php $ext = substr(strrchr($value['savename'], '.'), 1); ?>
					<a class="collection-item">
						<label class="left">
							<input type="checkbox" name="list[]" value="<?= $value['idx'] ?>"><span></span>
						</label>
						<i class="material-icons">
							<?php require "check.php" ?>
						</i>
						<?= $value['filename'] ?>
					</a>
				<?php endforeach ?>
			</div>
		</div>
		<div class="modal-footer input-field">
			<button type="submit" class="modal-action waves-effect waves-green btn-flat"><?= $lang_delete ?></button>
		</div>
	</form>
	<!-- delete form -->

	<!-- maindownload form -->
	<form id="downloada" class="modal" action="/download" method="POST">
		<div class="modal-content">
			<h4><?= $lang_download ?></h4>
			<p>&nbsp;</p>
			<div class="collection tab-content" style="overflow: auto">
				<?php foreach ($list as $key => $value) : ?>
					<?php $ext = substr(strrchr($value['savename'], '.'), 1); ?>
					<a class="collection-item">
						<label class="left">
							<input type="radio" name="idx" value="<?= $value['idx'] ?>"><span></span>
						</label>
						<i class="material-icons">
							<?php require "check.php" ?>
						</i>
						<?= $value['filename'] ?>
					</a>
				<?php endforeach ?>
			</div>
		</div>
		<div class="modal-footer input-field">
			<button type="submit" class="modal-action waves-effect waves-green btn-flat"><?= $lang_download ?></button>
		</div>
	</form>
	<!-- maindownload form -->

	<!-- upgrade form -->
	<form id="upgrade" class="modal" action="/upgrade" method="POST">
		<div class="modal-content">
			<h4>Plan Upgrade</h4>
			<p>&nbsp;</p>
			<div class="collection tab-content" style="overflow: auto">
					<a class="collection-item">
						<label class="left">
							<input type="radio" disabled><span></span>
						</label>
						Free
					</a>
					<a class="collection-item">
						<label class="left">
							<input type="radio" name="idx" <?php if ($max_stroge>="64420000000"){ echo "disabled";}?> value="Basic"><span></span>
						</label>
						Basic
					</a>
					<a class="collection-item">
						<label class="left">
							<input type="radio" name="idx" <?php if ($max_stroge>="107370000000"){ echo "disabled";}?> value="Pro"><span></span>
						</label>
						Pro
					</a>
					<a class="collection-item">
						<label class="left">
							<input type="radio" name="idx" <?php if ($max_stroge>="322120000000"){ echo "disabled";}?> value="Premium"><span></span>
						</label>
						Premium
					</a>
					<a class="collection-item">
						<label class="left">
							<input type="radio" name="idx" <?php if ($max_stroge>="1100000000000"){ echo "disabled";}?> value="Enterprise"><span></span>
						</label>
						Enterprise
					</a>
					<a class="collection-item">
						<label class="left">
							<input type="radio" name="idx" value="Other"><span></span>
						</label>
						Other
					</a>
			</div>
		</div>
		<div class="modal-footer input-field">
			<button type="submit" class="modal-action waves-effect waves-green btn-flat">Submit</button>
		</div>
	</form>
	<!-- upgrade form -->

	<!-- unregister form -->
	<form id="unreg" class="modal" action="/unregister" method="POST">
		<div class="modal-content">
			<h4><?= $lang_unreg ?></h4>
			<p>&nbsp;</p>
			<div class="file-field input-field">
				<p><?= $lang_unregwarn ?></p>
				<div class="input-field">
					<input type="text" id="sure" name="sure" autocomplete="off">
					<label for="sure"><?= $lang_unregcinput ?></label>
				</div>
			</div>
		</div>
		<div class="modal-footer input-field">
			<button type="submit" class="modal-action waves-effect waves-green btn-flat"><?= $lang_unregconfirm ?></button>
		</div>
	</form>
	</section>


