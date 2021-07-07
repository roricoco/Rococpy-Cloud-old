<?php 

    namespace Controller;

    use \model\_base as DB;

    class mainController {

        public function index() {

            if (USER) {
                $agree = DB::mq("SELECT * FROM cloud WHERE useridx=? && agree=?",[USER['idx'],"1"])->fetch();
                if ($agree) {
                    return move("/V3", "");
                }
                else{tcview("linecess");}
            }
            else{tcview("login");}
        }

        public function test() {

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
                    tcview("test",[
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

    }
 ?>
