								<?php if ($ext=="png"||$ext=="PNG"||$ext=="jpg"||$ext=="JPG"||$ext=="jpeg"||$ext=="JPEG"||$ext=="gif"||$ext=="GIF") : ?>
										image
									<?php elseif ($ext=="mp4"||$ext=="MP4"||$ext=="avi"||$ext=="webm"||$ext=="mkv") : ?>
										movie
									<?php elseif ($ext=="mp3"||$ext=="MP3"||$ext=="wav"||$ext=="WAV"||$ext=="midi"||$ext=="MIDI"||$ext=="flac"||$ext=="FLAC") : ?>
										music_note
									<?php elseif ($ext=="txt"||$ext=="TXT") : ?>
										notes
									<?php elseif ($ext=="html"||$ext=="HTML"||$ext=="php"||$ext=="PHP"||$ext=="js"||$ext=="JS"||$ext=="css"||$ext=="CSS"||$ext=="sql"||$ext=="SQL"||$ext=="BAT"||$ext=="cmd"||$ext=="CMD") : ?>
										code
									<?php else : ?>insert_drive_file
								<?php endif ?>