<?php $ext = substr(strrchr($file['savename'], '.'), 1); ?>
	<!-- main section -->
	<section id="main">
		<div class="card manager-header">
			<div class="container">
				<div class="projecttitle" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= USER['id'] ?>/Cloud/<?= $file['filename'] ?></div>
				<p><?= $lang_welcome ?></p>
			</div>
			<div class="divider"></div>
			<div class="container">
				<ul class="tabs row">
					<li class="tab col"><a href="#view"><?= $lang_viewtab1 ?></a></li>
					<li class="tab col"><a href="#edit"><?= $lang_viewtab2 ?></a></li>
					<li class="tab col"><a href="#info"><?= $lang_viewtab3 ?></a></li>
				</ul>
			</div>
		</div>
		<div class="container">

			<div id="view">
				<div class="card">

					<div class="codeview">

						<div class="head">
							<div class="title" style="white-space: wrap;"><?= $file['filename'] ?></div>
							<div class="blank"></div>
							<div class="viewbtns" style="display: flex;">
								<?php if ($ext=="gif"||$ext=="GIF") : ?>
									<a class="grey-text"><i class="material-icons">gif</i></a>
								<?php elseif ($ext=="mp4"||$ext=="MP4"||$ext=="webm"||$ext=="mkv"||$ext=="flac"||$ext=="FLAC") : ?>
									<a class="grey-text"><i class="material-icons">high_quality</i></a>
								<?php endif ?>
								<a class="grey-text waves-effect waves-red" onclick="history.back()"><i class="material-icons">undo</i></a>
        				<a class="grey-text waves-effect waves-red" href="/download/<?= $file['idx'] ?>"><i class="material-icons">file_download</i></a>   
								<a class="grey-text waves-effect waves-red backaction" data-type="Abandon" href="/Abandon/<?= $file['idx'] ?>"><i class="material-icons">delete</i></a>
							</div>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<?php if ($ext=="png"||$ext=="PNG"||$ext=="jpg"||$ext=="JPG"||$ext=="jpeg"||$ext=="JPEG"||$ext=="gif"||$ext=="GIF") : ?>
								<input type="hidden" class="load_img" value="<?= $file['savename'] ?>">
								<a href="javascript:showPopup();">
									<img width="100%" src="">
								</a>
							<?php elseif ($ext=="mp4"||$ext=="MP4"||$ext=="webm"||$ext=="mkv") : ?>
								<input type="hidden" class="load_video" value="<?= $file['savename'] ?>">
								<video controls width="100%" src="" controlsList="nodownload" poster="https://cdn.rococpy.com/other_img/nowload.png">
								</video>
							<?php elseif ($ext=="mp3"||$ext=="MP3"||$ext=="wav"||$ext=="WAV"||$ext=="midi"||$ext=="MIDI"||$ext=="flac"||$ext=="FLAC") : ?>
								<input type="hidden" class="load_audio" value="<?= $file['savename'] ?>">
								<audio style="width:100%" controls="controls" src="" controlsList="nodownload"></audio>
							<?php elseif ($ext=="txt"||$ext=="TXT") : ?>
								<?php $doc_data = join('', file( ROOT.$file['savename'] ));?>
								<pre style="font-family:'맑은 고딕'; white-space: pre-wrap; -moz-tab-size: 2; tab-size: 2;"><?php if(@iconv("EUC-KR", "UTF-8", $doc_data)): ?><?=iconv("EUC-KR", "UTF-8", $doc_data)?><?php else: ?><?=  $doc_data ?><?php endif ?>
								</pre>
							<?php elseif ($ext=="html"||$ext=="HTML"||$ext=="php"||$ext=="PHP"||$ext=="js"||$ext=="JS"||$ext=="css"||$ext=="CSS"||$ext=="sql"||$ext=="SQL"||$ext=="bat"||$ext=="BAT"||$ext=="cmd"||$ext=="CMD") : ?>
								<?php $doc_data = join('', file( ROOT.$file['savename'] ));?>
								<pre style="font-family:'맑은 고딕'; white-space: pre-wrap; -moz-tab-size: 2; tab-size: 2;"><?= htmlspecialchars($doc_data) ?></pre><?php else : ?><?= $lang_nopreview ?><?php endif ?> </div>
						<?php if ($file['note']==""||$file['note']==null) : ?>
							<?php else: ?>
							<div class="card-content">
								<h5>Note</h5>
								<p><?= $file['note'] ?></p>
							</div>
						<?php endif ?>

					</div>

				</div>
			</div>
			
			<div id="edit">
				<div class="card">
					<div class="collection tab-content">
						<div>
							<div class="collection-item">
								<a class="title"><?= $lang_filenameedit ?></a>
								<div>
									<input type="text" value="<?= $fname[0] ?>" id="filename" name="filename">
									<input type="hidden" id="check" value="Q2hlY2tpbmcgRmlsZSBlZGl0" name="check">
								</div>
							</div>
							<div class="collection-item">
								<a class="title"><?= $lang_fileshareedit ?></a>
								<div>
									<label class="custom-switch">
    								<input type="checkbox" hidden name="share" id="share" value="1" <?php if ($file['share']==1) {echo "checked";}?> class="custom-switch-input">
    								<div class="custom-switch-indicator1"></div>
								</div>
							</div>
							<div class="collection-item">
								<a class="title"><?= $lang_filesharecountedit ?><sub><?= $lang_filesharecountunlmt ?></sub></a>
								<div>
									<input type="number" name="life" id="life" min="-1" max="2147483647" required value="<?= $file['share_life'] ?>">
								</div>
							</div>
							<div class="collection-item">
								<a class="title"><?= $lang_noteedit ?></a>
								<div>
									<input type="text" name="note" id="note" value="<?= htmlspecialchars($file['note']) ?>">
								</div>
							</div>
							<div class="collection-item">
								<BUTTON class="waves-effect waves-light btn" onclick="edit.save(<?= $file['idx'] ?>, '<?= $lang_editcomp ?>')"><?= $lang_editsave ?></BUTTON>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div id="info">
				<div class="card">

					<div class="collection tab-content">
						<div class="collection-item">
							<a class="title"><?= $lang_uploaddate ?></a>
							<div><?= $file['date'] ?></div>
						</div>
						<div class="collection-item">
							<a class="title"><?= $lang_filesize ?></a>
							<div><?= formatSize(filesize(".".$file['savename'])) ?></div>
						</div>
						<div class="collection-item">
							<a class="title"><?= $lang_fileformat ?></a>
							<div><?= $ext ?></div>
						</div>


						<div class="collection-item">
							<a class="title"><?= $lang_fileshare ?></a><?php if ($file['share']!=0):?><a class="right" href="/view/<?= $file['idx']?>/share">Link</a><?php endif ?>
							<div><?php if ($file['share']!=0):?><?= $lang_shareon ?><?php else:?><?= $lang_shareoff ?><?php endif ?></div>
						</div>
						<?php if ($file['share']!=0):?>
							<div class="collection-item">
								<a class="title"><?= $lang_filesharecount ?></a>

								<div><?php if ($file['share_life']==-1) : ?><?= $lang_shareunlimit ?><?php else : ?><?= $lang_sharelimit?><?php endif ?></div>
							</div>
						<?php endif ?>
						<div class="collection-item">
							<a class="title"><?= $lang_filestats ?></a>
							<div><?= $file['stats'] ?></div>
						</div>
					</div>

				</div>
			</div>
	</section>
