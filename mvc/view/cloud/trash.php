<!-- main section -->
	<section id="main">
		<div class="card manager-header">
			<div class="container">

				<div class="projecttitle"><?= USER['id'] ?>/Cloud/Trash</div>
				<p><?= $lang_welcome ?></p>

			</div>
			<div class="divider"></div>
			<div class="container">

				<ul class="tabs row">
					<li class="tab col"><a href="#code"><?= $lang_maintab1 ?></a></li>
					<li class="tab col"><a href="#compare"><?= $lang_maintab3 ?></a></li>
				</ul>

			</div>
		</div>
		<div class="container">

			<div id="code">
				<div class="card">

					<div class="btn_group">							
						<button class="waves-effect waves-light btn modal-trigger" href="#restone"><i class="material-icons">restore</i><?= $lang_restone ?></button>
						<button class="waves-effect waves-light btn modal-trigger right red lighten-1" href="#delete"><i class="material-icons" style="margin:0!important">delete</i><?= $lang_alwdelete ?></button>
					</div>

					<div class="divider"></div>

					<div class="collection tab-content">
						<a class="collection-item dnt_mv_t_mv" href="/"><i class="material-icons">keyboard_return</i>...</a>
						<?php foreach ($list as $key => $value) : ?>
							<?php $ext = substr(strrchr($value['savename'], '.'), 1); ?>
							<a class="collection-item">
								<i class="material-icons">
									<?php require "check.php" ?>
								</i><?= $value['filename'] ?>
							</a>

						<?php endforeach ?>

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

		<form id="delete" action="/delete" class="modal" method="POST">
		<div class="modal-content">
			<h4><?= $lang_alwdelete ?></h4>
			<p><?= $lang_alwdeletewarn ?></p>
			<div class="collection tab-content" style="overflow: auto">
				<?php foreach ($list as $key => $value) : ?>
					<?php $ext = substr(strrchr($value['savename'], '.'), 1); ?>
					<a class="collection-item">
						<label class="left">
							<input type="checkbox" class="rmdelete" name="list[]" value="<?= $value['idx'] ?>"><span></span>
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
	<!-- upload form -->

	<!-- upload form -->
	<form id="restone" class="modal" action="/restore" method="POST">
		<div class="modal-content">
			<h4><?= $lang_restone ?></h4>
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
			<button type="submit" class="modal-action waves-effect waves-green btn-flat"><?= $lang_restone ?></button>
		</div>
	</form>
	</section>
	<!-- main section -->


