<?php
//--------------------------前処理----------------------------
if(!isset($msg)){
  $Ename = "";
  $Ecategory = "";
  $Emsg = "";
}

//config呼出
require_once '../../config.php';


//----------------削除---------------------
//削除が押されたら実行
if (isset($_POST['delete'])) {
  //DB接続
  $cn = mysqli_connect(HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($cn, 'utf8');
  $sql = "UPDATE t_post SET del_flg = 1 WHERE id = ".$_POST['delete'].";";
  mysqli_query($cn, $sql);
  mysqli_close($cn);
}


//----------------読込---------------------
//DB接続
$cn = mysqli_connect(HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($cn, 'utf8');
  //検索が押されたら実行
  if(!isset($_POST['search'])){
      $sql = "SELECT id,name,msg,category,post_date FROM t_post WHERE del_flg = 0 ORDER BY post_date DESC;";
  }
  else{
      $categoryNum = $_POST['tlCategory'];
      $category=['','映画','本','音楽'];
      $sql = "SELECT id,name,msg,category,post_date FROM t_post WHERE category = '".$category[$categoryNum]."' AND del_flg = 0 ORDER BY post_date DESC;";
  }
  $result = mysqli_query($cn, $sql);
  $row = mysqli_fetch_assoc($result);
  //中身があればループ
  while($row){
    $fromData[] = $row;
    $row = mysqli_fetch_assoc($result);
  }
  mysqli_close($cn);



//--------------------------主処理-----------------------------

//----------------投稿----------------------
//二重投稿対策
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //ボミートが押されたら実行
    if (isset($_POST['post'])) {
        $img = $_FILES['img'];

        //空白チェック
        if (empty($_POST['name'])) {
            $Ename = "未入力";
        }
        if ($_POST['category'] == 0) {
            $Ecategory = "未選択";
        }
        if (empty($_POST['msg']) && empty($img['img'])) {
            $Emsg = "未入力";
        }
        //全クリしたらDBに登録する
        if (empty($Ename) && empty($Ecategory) && empty($Emsg)) {
            $category=['','映画','本','音楽'];
            $toData=[
            'name' => $_POST['name'],
            'msg' => $_POST['msg'],
            'category' => $category[$_POST['category']],
          ];
            //DB接続
            $cn = mysqli_connect(HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_set_charset($cn, 'utf8');

            //idをDBからとってくる
            $sql = "SELECT MAX(id) FROM t_post;";
            $result = mysqli_query($cn, $sql);
            $id = mysqli_fetch_assoc($result);
            if ($id['MAX(id)'] == null) {
                $id['MAX(id)'] = 1;
            } else {
                $id['MAX(id)']++;
            }

            //DBに登録
            $sql = "INSERT INTO t_post(id,name,msg,category,reply_id,del_flg,post_date) VALUES('".$id['MAX(id)']."','".$toData['name']."', '".$toData['msg']."', '".$toData['category']."', 0 , 0 , now());";
            mysqli_query($cn, $sql);
            mysqli_close($cn);

            //画像のアップロード
            move_uploaded_file($img['tmp_name'], UPLOAD_PATH.$id['MAX(id)'].'.jpg');

            //GET(header)で飛んで二重投稿対策
            header('Location:index.php');
            exit();
        };
    };
}



//--------------------------後処理-----------------------------
//view呼出
require_once 'tpl/index.php';

?>