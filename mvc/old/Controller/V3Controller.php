<?php 
    namespace Controller;

    use \model\_base as DB;

    class V3Controller {

        public function index() {

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"])->fetch();
                if ($agree) {
                    $max_stroge = $agree['max_stroge'];
                    $list = DB::mq("SELECT * FROM cloudlist WHERE useridx=? && stats=?",[USER['idx'], "Normal"])->fetchAll();
                    $files = DB::mq("SELECT * FROM cloudlist WHERE useridx=?",[USER['idx']])->rowcount();
                    $afiles = DB::mq("SELECT * FROM cloudlist WHERE useridx=?",[USER['idx']])->fetchAll();
                    $tfiles = DB::mq("SELECT * FROM cloudlist WHERE useridx=? && stats=?",[USER['idx'], "trash"])->rowcount();
                    $max=0;
                    foreach ($afiles as $key => $value){$max += filesize(".".$value['savename']);}
                    tcview("index",[
                        'list' => $list,
                        'max' => $max,
                        'max_stroge' => $max_stroge,
                        'files' => $files,
                        'tfiles' => $tfiles,
                        'afiles' => $afiles
                    ]);
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function trash() {

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"])->fetch();
                if ($agree) {
                    $max_stroge = $agree['max_stroge'];
                    $list = DB::mq("SELECT * FROM cloudlist WHERE useridx=? && stats=?",[USER['idx'], "trash"])->fetchAll();
                    tcview("trash",[
                        'list' => $list,
                    ]);
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}            
        }

        public function view($idx) {

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"]);
                if ($agree) {

                    $file = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();
                    $ext = pathinfo($file['savename'], PATHINFO_EXTENSION);
                    $fname = explode(".".$ext, $file['filename']);
                    if ($file['useridx']==USER['idx']) {
                        if ($file['stats']!="Normal") {return move("/", "???????????? ?????? ????????? ???????????? ??? ????????????.");}
                        tcview("view",[
                            'file' => $file,
                            'fname' => $fname,
                        ]);
                    }
                    else{return move("/", "????????? ????????? ????????????");}
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function viewimg($idx) {

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"]);
                if ($agree) {

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
                    }
                    else{return move("/", "????????? ????????? ????????????");}
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function accept() {
        	error_reporting(0);
        	if (USER) {
        		if (isset($_POST['check_true'])) {
        			DB::mq("INSERT INTO cloud SET useridx=?, agree=?",[USER['idx'], "1"]);
        			$asdf=$_SERVER['DOCUMENT_ROOT']."/file/cloud/".$_SESSION['user']['id']."/";
        			mkdir($asdf, 0777, true);
        			
        			return move("/", "??????????????? ?????????????????????.");
        		}
        		else{return move("/", "????????? ???????????????.");}
        	}
        	else{return move("/", "????????? ???????????????.");}
        }

        public function uploaded() {
        	if (USER) {
        		$agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"])->fetch();
        		if ($agree) {
                    $list = DB::mq("SELECT * FROM cloudlist WHERE useridx=?",[USER['idx']])->fetchAll();
                    $max=0;
                    foreach ($list as $key => $value){$max += filesize(".".$value['savename']);}
            		$img=$_FILES['upload'];
                	$tmp=$img['tmp_name'];
                	$name=$img['name'];
                    if ($img['size']+$max > $agree['max_stroge']) {return move("/", "????????? ???????????? ??? ?????? ???????????? ?????? ??? ??? ????????????.");}

                	if ($tmp!=""||$tmp!=null) {
	
    					$micro = microtime();
                	    $fn = md5($name.$micro); 
                	    $ext = pathinfo($name, PATHINFO_EXTENSION);
                        if (move_uploaded_file($img['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/file/cloud/".USER['id']."/$fn.$ext")) {
                            DB::insert("cloudlist", [
                                'useridx' => USER['idx'],
                                'filename' => $name,
                                'savename' => "/file/cloud/".USER['id']."/$fn.$ext",
                                'date' => date("Y-m-d H-m-s"),
                                'note' => $_POST['note'],
                            ]);
                            return move("/", "???????????? ??????????????????. ?????? ????????????????????????.");
                        }
                        else{return move("/", "???????????? ???????????????.");}
                	}
                	else{return move("", "????????? ??? ????????? ?????????.");}
        		}
        		else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function download($idx = []) {
            extract($_POST);
            if (empty($idx)||$idx=="") {return move("/", "????????? ????????? ????????????.");}
            $file = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"]);
                if ($agree) {
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
                else{tcview("linecess");}
                }
            else{tcview("login");} 
        }

        public function Abandon($idx=[]){

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"]);
                if ($agree) {
                    if ($_POST) {
                        extract($_POST);
                        foreach ($list as $key => $value) {$file[] = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$value])->fetch();}
                        foreach ($file as $key => $value) {
                            if ($value['useridx']==USER['idx']) {DB::mq("UPDATE cloudlist SET stats=? WHERE idx=?",["trash", $value['idx']]);}
                            else{return move("", "????????? ???????????? ????????? ????????????.");}
                        }
                        return move("/", "????????? ??????????????? ??????????????????.");
                    }
                    else{
                        $file = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();
                        if ($file['useridx']==USER['idx']) {
                            $info = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();
                            DB::mq("UPDATE cloudlist SET stats=? WHERE idx=?",["trash", $idx]);
                            return move("/", "????????? ??????????????? ??????????????????.");
                        }
                        else{return move("", "????????? ???????????? ????????? ????????????.");}
                    }
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function delete(){
            extract($_POST);
            if (empty($_POST)) {return move("", "????????? ????????? ????????????.");}
            foreach ($list as $key => $value) {$file[] = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$value])->fetch();}

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"]);
                if ($agree) {
                    foreach ($file as $key => $value) {
                        if ($value['useridx']==USER['idx']) {
                            $info = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$value['idx']])->fetch();
                            $handle = fopen(ROOT.$value['savename'], "r");
                            fclose($handle);
                            if (unlink(ROOT.$value['savename'])) {DB::mq("DELETE FROM cloudlist WHERE idx=?",[$value['idx']]);}
                            else{return move("/V3/trash","?????? ?????? ??? ????????? ??????????????????. ?????? ??????????????????.");}
                        }
                    }
                    return move("/V3/trash", "????????? ?????????????????????."); 
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function restore(){
            extract($_POST);
            foreach ($list as $key => $value) {$file[] = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$value])->fetch();}

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"]);
                if ($agree) {
                    foreach ($file as $key => $value) {
                        if ($value['useridx']==USER['idx']) {DB::mq("UPDATE cloudlist SET stats=? WHERE idx=?",["Normal", $value['idx']]);}
                    }
                    return move("/", "????????? ???????????? ?????????????????????."); 
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function unregister(){

        	if (USER) {
        		$agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"]);
        		if ($agree) {
            		if ($_POST['sure']==="???????????????." || $_POST['sure']=="I agree.") {

            			$directory = ROOT."/File/cloud/".USER['id']."/";
						$handle = opendir($directory); // ????????????
						while ($file = readdir($handle)) {@unlink($directory.$file);}
						closedir($handle);
        				$asdf=$_SERVER['DOCUMENT_ROOT']."/file/cloud/".$_SESSION['user']['id'];
            			rmdir($asdf);
            			DB::mq("DELETE FROM cloudlist WHERE useridx=?",[USER['idx']]);
            			DB::mq("DELETE FROM cloud WHERE useridx=?",[USER['idx']]);

            			return move("/", "??????????????? ??????????????????. ?????????????????? ???????????????.");
            		}
            		else{return move("", "??????????????? ???????????? ?????????.");}
        		}
        		else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function edit($idx){
            extract($_POST);
            if (@$check !== "Q2hlY2tpbmcgRmlsZSBlZGl0") {return move("", "???????????? ?????? ???????????????.");}
            $original = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();
        	if (empty($life)) {$life="0";}
        	if (empty($share) || $share == false) {$share="0";}
            else if ($share == true) {$share="1";}
            if (empty($note)||$note=="") {$note=null;}
            if (empty($filename)||$filename=="") {$filename=$original['filename'];}
            $ext = pathinfo($original['savename'], PATHINFO_EXTENSION);
        	if (USER) {
        		$agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"]);
        		if ($agree) {
        			$editlist = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();
        			if (USER['idx']==$editlist['useridx']) {
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
        		else{tcview("linecess");}
            }
            else{tcview("login");}
        }


        public function switch_dark(){

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"])->fetch();
                if ($agree) {
                    if ($agree['dark']=="0") {
                        DB::mq("UPDATE cloud SET dark=1 WHERE useridx=?",[USER['idx']]);
                        return 0;
                    }

                    else if ($agree['dark']=="1") {
                        DB::mq("UPDATE cloud SET dark=0 WHERE useridx=?",[USER['idx']]);
                        return move("", "");
                    }

                    else {
                        DB::mq("UPDATE cloud SET dark=0 WHERE useridx=?",[USER['idx']]);
                        return move("", "");
                    }
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function change_layout(){

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"])->fetch();
                if ($agree) {
                    if ($agree['layout']=="0") {
                        DB::mq("UPDATE cloud SET layout=1 WHERE useridx=?",[USER['idx']]);
                        return 0;
                    }

                    else if ($agree['layout']=="1") {
                        DB::mq("UPDATE cloud SET layout=0 WHERE useridx=?",[USER['idx']]);
                        return 0;
                    }

                    else {
                        DB::mq("UPDATE cloud SET layout=0 WHERE useridx=?",[USER['idx']]);
                        return 0;
                    }
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function language() {
            DB::mq("UPDATE cloud SET language=? WHERE useridx=?", [
                $_POST['data'],
                USER['idx']
            ]);
            
        }

        public function upgrade(){
            extract($_POST);

            dd($_POST);
        }
    }
 ?>
