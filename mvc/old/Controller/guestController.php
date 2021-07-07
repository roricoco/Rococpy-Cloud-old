<?php 

    namespace Controller;

    use \model\_base as DB;

    class guestController {

        public function index() {return move("/", "");}

        public function view($idx){
        	$file = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();
        	$name = DB::mq("SELECT * FROM user WHERE idx=?",[$file['useridx']])->fetch();
        	if ($file['share']==1) {
        		gview("guest_dwn",[
        			'file'=>$file,
        			'name'=>$name
        		]);
        	}
        	else{return move("", "파일공유가 허락되지 않은 파일입니다.");}
        }

        public function download($idx){

            $file = DB::mq("SELECT * FROM cloudlist WHERE idx=?",[$idx])->fetch();

            if ($file['share']==1) {
                if ($file['share_life']==0) {
                    return move("", "다운로드 가능한 횟수가 부족합니다.");
                }

                elseif ($file['share_life']<=-2) {
                    return move("", "Unknown Error");
                }

                else{
                    if ($file['share_life']!=-1) {
                        if ($file['useridx']!=USER['idx']) {
                            DB::mq("UPDATE cloudlist SET share_life=? WHERE idx=?",[$file['share_life']-1, $idx]);
                        }
                    }

                    $filepath = '.'.$file['savename'];
                    $filesize = filesize($filepath);
                    $filename = $file['filename'];
                    session_write_close();
        
                    $handle = fopen($filepath, "rb");
                    header("Cache-Control: no-cache, must-revalidate"); 
                    header("Pragma: no-cache");
                    header("Content-Disposition: attachment; filename=\"$filename\"");
                    header("Content-Type: application/octet-stream");
                    header('Content-Transfer-Encoding: binary');
                    header('Expires:0');
                     
                    while(!feof($handle)){
                        print(fread($handle, 1024*80));
                        flush();
                    }
                    return 0;
                }
            }

            else{
                return move("", "파일공유가 허용되지 않았습니다.");
            }
        }
    }

?>
