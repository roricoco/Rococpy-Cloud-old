<?php 
  isBlockBrowser();

	get("/", function() {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
      $max = 0;
			$max_stroge = LINECESS['max_stroge'];
      $count = DB::count("cloudlist", "useridx=?", [USER['idx']]);
      $usedisk = DB::findall("cloudlist", "useridx=?", [USER['idx']]);
      $list = DB::findall("cloudlist", "useridx=? && stats=?", [USER['idx'], "Normal"]);
      $trash_file = DB::count("cloudlist", "useridx=? && stats=?", [USER['idx'], "trash"]);
      foreach ($usedisk as $key => $value){$max += filesize(".".$value['savename']);}
      view("index", [
        'list' => $list,
        'max' => $max,
        'max_stroge' => $max_stroge,
        'count' => $count,
        'trash_file' => $trash_file,
        'usedisk' => $usedisk
      ]);
		}
	});

	get("/info/$", function($val) {
	    $using = 0;
	    $max_stroge = LINECESS['max_stroge'];
	    $count = DB::count("cloudlist", "useridx=?", [USER['idx']]);
	    $usedisk = DB::findall("cloudlist", "useridx=?", [USER['idx']]);
	    $list = DB::findall("cloudlist", "useridx=? && stats=?", [USER['idx'], "Normal"]);
	    $trash_file = DB::count("cloudlist", "useridx=? && stats=?", [USER['idx'], "trash"]);
	    foreach ($usedisk as $key => $value){$using += filesize(".".$value['savename']);}
	    switch ($val) {
	      case 'main_info':
	          echo json_encode(["use" => $using, "max" => $max_stroge, 'file' => $count, 'trash' => $trash_file]);
	          return 0;
	        break;
	    }
	});

	get("/trash", function() {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
      $list = DB::mq("SELECT * FROM cloudlist WHERE useridx=? && stats=?",[USER['idx'], "trash"])->fetchAll();
      view("trash",[
        'list' => $list,
      ]);
		}
	});


	get("/view/$", function($idx) {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
    	$file = DB::find("cloudlist", "idx=?",[$idx]);
      if (@$file['useridx']==USER['idx']) {
        $ext = pathinfo($file['savename'], PATHINFO_EXTENSION);
        $fname = explode(".".$ext, $file['filename']);
        if ($file['stats']!="Normal") {return move("/", "???????????? ?????? ????????? ???????????? ??? ????????????.");}
        view("view",[
          'file' => $file,
          'fname' => $fname,
        ]);
      } else{return move("/", "????????? ????????? ????????????");}
		}
	});


	get("/view/img/$", function($idx) {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
      $file = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();
      $ext = pathinfo($file['savename'], PATHINFO_EXTENSION);
      $fname = explode(".".$ext, $file['filename']);
      if ($file['useridx']==USER['idx']) {
        if ($file['stats']!="Normal") {return move("/", "???????????? ?????? ????????? ???????????? ??? ????????????.");}
        $path = '.'.$file['savename'];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        echo '<img onclick="window.close()" style="cursor:pointer" width="100%" src='.$base64.'>';
      } else{return move("/", "????????? ????????? ????????????");}
		}
	});

	get("/download/$", function($idx) {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
      if (empty($idx)||$idx=="") {return move("/", "????????? ????????? ????????????.");}
      $file = DB::find("cloudlist", "idx=?",[$idx]);
      if ($file['useridx']==USER['idx']) {
      	$filepath = '.'.$file['savename'];
      	$filename = $file['filename'];
      	$filesize = filesize($filepath);
      	session_write_close();

      	$fp = fopen($filepath, "r");
      	header('Content-Type: application/octet-stream');
      	header("Pragma: public");
      	header("Expires: 0");
      	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      	header("Cache-Control: public");
      	header("Content-Type: application/force-download");
      	header("Content-Type: application/download");
      	header("Content-Description: File Transfer");            
      	header("Content-length:".$filesize);
      	header('Content-Disposition: attachment; filename='.$filename);
      	header('Content-Transfer-Encoding: binary');
      	ob_end_clean();

      	readfile($filepath);
      	exit();

      	//slow
      	/*$contentDispositionField = 'Content-Disposition: attachment; '
      	    . sprintf('filename="%s"; ', rawurlencode($filename))
      	    . sprintf("filename*=utf-8''%s", rawurlencode($filename));
      	
      	header('Content-Type: application/octet-stream');
      	header("Content-Length: " . filesize($filepath));
      	
      	header($contentDispositionField);
      	
      	while (!feof($filepath))
      	{
      	    echo fread($filepath, 65536);
      	    flush();
      	} */

      	//dead
      	/*header("Content-Disposition: attachment; filename=".$filename);
      	header("Content-Type: application/octet-stream");
      	header("Content-Type: application/force-download");
      	header("Content-Type: application/download");
      	header("Content-Description: File Transfer");            
      	header("Content-Length: " . filesize($filepath));
      	flush(); // this doesn't really matter.

      	$fp = fopen($filepath, "r");
      	while (!feof($fp))
      	{
      	    echo fread($fp, 65536);
      	    flush();
      	} 
      	fclose($fp);*/
      
      	//dead
      	/* $handle = fopen($filepath, "rb");
      	header("Cache-Control: no-cache, must-revalidate"); 
      	header("Pragma: no-cache");
      	header("Content-Disposition: attachment; filename=\"$filename\"");
      	header("Content-Length: $filesize");
      	header("Content-Type: application/octet-stream");
      	header('Content-Transfer-Encoding: binary');
      	header('Expires:0');
      	            	 
      	while(!feof($handle)){
      	    echo fread($handle, 1024*8);
      	    flush();
      	}
      	fclose($handle);
      	return 0;
      	fpassthru($handle);*/
      }
      else{return move("/", "Unknown Error");}
		}
	});


	get("/Abandon/$", function($idx) {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
      $file = DB::find("cloudlist", "idx=?", [$idx]);
      if ($file['useridx']==USER['idx']) {
        DB::mq("UPDATE cloudlist SET stats=? WHERE idx=?",["trash", $idx]);
        return printf("????????? ??????????????? ??????????????????.");
      } else{return printf("????????? ???????????? ????????? ????????????.");}
		}
	});

	//post

	post("/accept", function(){
		if (!USER) {
			login();
		} else{
			if (isset($_POST['check_true'])) {
        DB::mq("INSERT INTO cloud SET useridx = ?, agree = ?",[USER['idx'], "1"]);
        mkdir(ROOT."/file/cloud/".$_SESSION['user']['id']."/", 0777, true);
        
        return move("/", "??????????????? ?????????????????????.");
      } else{return move("/", "????????? ???????????????.");}
    }
	});


	post("/unregister", function() {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
			if ($_POST['sure'] == "???????????????." || $_POST['sure'] == "I agree.") {
        $directory = ROOT."/File/cloud/".USER['id']."/";
				$handle = opendir($directory);
				while ($file = readdir($handle)) {@unlink($directory.$file);}
				closedir($handle);
        rmdir($directory);

        DB::mq("DELETE FROM cloudlist WHERE useridx=?",[USER['idx']]);
        DB::mq("DELETE FROM cloud WHERE useridx=?",[USER['idx']]);
	
        return move("/", "??????????????? ??????????????????. ?????????????????? ???????????????.");
      } else{return move("/", "??????????????? ???????????? ?????????.");}
    }
	});

	post("/download", function(){
    extract($_POST);
    $idxs = json_decode($idxs);

    header("location:/download/".$idxs[0]);
	});

  post("/uploaded", function() {
    if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
			$list = DB::mq("SELECT * FROM cloudlist WHERE useridx=?",[USER['idx']])->fetchAll();
      $max = 0;
      foreach ($list as $key => $value){$max += filesize(".".$value['savename']);}
      $img = $_FILES['upload'];
      $tmp = $img['tmp_name'];
      $name = $img['name'];
      if ($img['size']+$max > LINECESS['max_stroge']) {return move("/", "????????? ???????????? ??? ?????? ???????????? ?????? ??? ??? ????????????.");}

      if ($tmp!=""||$tmp!=null) {
    		$micro = microtime();
        $fn = md5($name.$micro); 
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if (move_uploaded_file($img['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/file/cloud/".USER['id']."/$fn.$ext")) {
          $idx = DB::insert("cloudlist", [
              'useridx' => USER['idx'],
              'filename' => $name,
              'savename' => "/file/cloud/".USER['id']."/$fn.$ext",
              'date' => date("Y-m-d H-m-s"),
              'note' => $_POST['note'],
          ]);
          echo json_encode(['filename' => $name, 'idx' => $idx]);
        } else{return move("/", "???????????? ???????????????.");}
        } else{return move("", "????????? ??? ????????? ?????????.");}
		}
	});

  post("/upload", function() {
    if (!USER) {
      login();
    } else if (!LINECESS) {
      linecess();
    } else{
      $max = 0;
      $upload_max = 0;
      $json = [];
      $file = files_format($_FILES['upload']);
      $list = DB::mq("SELECT * FROM cloudlist WHERE useridx = ?", [USER['idx']])->fetchAll();

      foreach ($list as $key => $value) { $max += filesize(".".$value['savename']); }
      foreach ($file as $key => $value) { $upload_max += $value['size']; }

      if ($upload_max + $max > LINECESS['max_stroge']) {
        echo "????????? ???????????? ??????????????? ???????????????!";
        return;
      }

      foreach ($file as $key => $value) {
        $tmp = $value['tmp_name'];
        $name = $value['name'];

        if ($tmp != "" || $tmp != null) {
          $fn = md5($name.microtime()); 
          $ext = pathinfo($name, PATHINFO_EXTENSION);
          $loc = "/file/cloud/".USER['id']."/$fn.$ext";

          if (move_uploaded_file($tmp, ROOT.$loc)) {
            $idx = DB::insert("cloudlist", [
                'useridx' => USER['idx'],
                'filename' => $name,
                'savename' => $loc,
                'date' => date("Y-m-d H-m-s"),
                'note' => $_POST['note'],
            ]);
            $json[] = ['filename' => $name, 'idx' => $idx];
          } else{return move("/", "???????????? ???????????????.");}
        } else{return move("", "????????? ??? ????????? ?????????.");}
      }
      echo json_encode($json);
    }
  });


	post("/edit/$", function($idx) {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
			extract($_POST);
      if (@$check !== "Q2hlY2tpbmcgRmlsZSBlZGl0") {return move("", "???????????? ?????? ???????????????.");}
      $original = DB::find("cloudlist", "idx=?",[$idx]);
      if (empty($life)) {$life="0";}
      if (empty($share) || $share == false) {$share="0";}
      else if ($share == true) {$share="1";}
      if (empty($note)||$note=="") {$note=null;}
      if (empty($filename)||$filename=="") {$filename=$original['filename'];}
      $ext = pathinfo($original['savename'], PATHINFO_EXTENSION);
      if (USER['idx']==$original['useridx']) {
      	DB::mq("UPDATE cloudlist SET filename=?, share=?, share_life=?, note=? WHERE idx=?",[
          $filename.".".$ext,
      		$share,
          $life,
      		$note,
      		$idx
        ]);
      	return move("", "????????? ??????????????????.");
      }
      else{return move("", "Error 403");}
		}
	});


	post("/Abandon", function() {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
			extract($_POST);
      $idxs = json_decode($idxs);

      foreach ($idxs as $key => $value) {$file[] = DB::find("cloudlist", "idx=?", [$value]);}
      foreach ($file as $key => $value) {
        if ($value['useridx']==USER['idx']) {DB::mq("UPDATE cloudlist SET stats=? WHERE idx=?",["trash", $value['idx']]);}
        else{return printf("????????? ???????????? ????????? ????????????.");}
      }
      return printf("????????? ??????????????? ??????????????????.");
    }
	});


	post("/restore", function() {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
			extract($_POST);

      $idxs = json_decode($idxs);
      if (empty($idxs)) {return printf("????????? ????????? ????????????.");}

      foreach ($idxs as $key => $value) {$file[] = DB::find("cloudlist", "idx=?", [$value]);}
      foreach ($file as $key => $value) {
        if ($value['useridx'] == USER['idx']) {DB::mq("UPDATE cloudlist SET stats=? WHERE idx=?",["Normal", $value['idx']]);}
      }
      return printf("????????? ???????????? ?????????????????????."); 
    }
	});


	post("/delete", function() {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
			extract($_POST);

      $idxs = json_decode($idxs);

      if (empty($idxs)) {return printf("????????? ????????? ????????????.");}
      foreach ($idxs as $key => $value) {$file[] = DB::find("cloudlist","idx=?",[$value]);}
      foreach ($file as $key => $value) {
        if ($value['useridx']==USER['idx']) {
          $info = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$value['idx']])->fetch();
          $handle = fopen(ROOT.$value['savename'], "r");
          fclose($handle);
          if (unlink(ROOT.$value['savename'])) {DB::mq("DELETE FROM cloudlist WHERE idx=?",[$value['idx']]);}
          else{return printf("?????? ?????? ??? ????????? ??????????????????. ?????? ??????????????????.");}
        }
      }
      return printf("????????? ?????????????????????."); 
    }
	});


	post("/switch_dark", function() {
		if (!USER) {
			login();
		}	else if (!LINECESS) {
			linecess();
		}	else{
      if (LINECESS['dark']=="0") {
        echo "darkmode";
        return DB::mq("UPDATE cloud SET dark=1 WHERE useridx=?",[USER['idx']]);

      } else if (LINECESS['dark']=="1") {
        echo "lightmode";
        return DB::mq("UPDATE cloud SET dark=0 WHERE useridx=?",[USER['idx']]);

      } else {
        echo "lightmode";
        return DB::mq("UPDATE cloud SET dark=0 WHERE useridx=?",[USER['idx']]);
      }
		}
	});


	post("/change_layout", function() {
		if (!USER) {
			login();
		} else if (!LINECESS) {
			linecess();
		} else{
      if (LINECESS['layout']=="0") {return DB::mq("UPDATE cloud SET layout=1 WHERE useridx=?",[USER['idx']]); }
      else if (LINECESS['layout']=="1") {return DB::mq("UPDATE cloud SET layout=0 WHERE useridx=?",[USER['idx']]); }
      else {return DB::mq("UPDATE cloud SET layout=0 WHERE useridx=?",[USER['idx']]); }
		}
	});


	post("/language", function() {
		if (!USER) {
			login();
		} else if (!LINECESS) {
			linecess();
		} else{
      DB::mq("UPDATE cloud SET language=? WHERE useridx=?", [$_POST['data'], USER['idx'] ]);
		}
	});


	post("/upgrade", function() {
		if (!USER) {
			login();
		}
		else if (!LINECESS) {
			linecess();
		}
		else{
      extract($_POST);

      dd($_POST);
		}
	});


	//guest

	get("/view/$/share", function($idx) {
		$file = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();
    if (@$file['share'] == 1) {
      $name = DB::mq("SELECT * FROM user WHERE idx=?",[$file['useridx']])->fetch();
    	gview("guest_dwn",[
    		'file'=>$file,
    		'name'=>$name
    	]);
    }
    else{return move("/", "??????????????? ???????????? ?????? ???????????????.");}
	});


	get("/download/$/share", function($idx) {
		$file = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();
    if ($file['share'] == 1) {
      if ($file['share_life'] == 0) {
         return move("", "???????????? ????????? ????????? ???????????????.");
      } elseif ($file['share_life'] <= -2) {
          return move("", "Unknown Error");
      } else{
        if ($file['share_life'] != -1) {
          if ($file['useridx'] != USER['idx']) {
            DB::mq("UPDATE cloudlist SET share_life=? WHERE idx=?",[$file['share_life']-1, $idx]);
          }
        }

        $filepath = '.'.$file['savename'];
        $filesize = filesize($filepath);
        $filename = $file['filename'];
        session_write_close();
        
        $fp = fopen($filepath, "r");
        header('Content-Type: application/octet-stream');
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Type: application/force-download");
        header("Content-Type: application/download");
        header("Content-Description: File Transfer");            
        header("Content-length:".$filesize);
        header('Content-Disposition: attachment; filename='.$filename);
        header('Content-Transfer-Encoding: binary');
        ob_end_clean();

        readfile($filepath);
        exit();
        }
      }

      else{return move("/", "??????????????? ???????????? ???????????????."); }
	});

?>