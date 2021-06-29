<?php
//---------------------前処理-----------------------


//---------------------主処理------------------------


//---------------------後処理------------------------
?>



<!doctype html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Bomitter</title>
</head>

<body>

<div id="wrapper">


  <div id="header">

    <h1><a href="index.php">Bomitter</a></h1>
    <!-- タイトル -->
    <form method="post">
      <select name="tlCategory">
        <option value="0" selected>選択してください</option>
        <option value="1">映画</option>
        <option value="2">本</option>
        <option value="3">音楽</option>
      </select>
      <button type="submit" name="search">検索</button>
    </form>
    <!-- ジャンル検索 -->

    <div class="pop-box">
      <label for="popup-on1">
        <div class="btn-open">
          <p>ボミートする</p>
        </div>
      </label>

      <input type="checkbox" id="popup-on1">
        <div class="popup">
          <div class="popup-content">
            <form method="post" enctype="multipart/form-data">
              <table>
                <tr>
                  <td>ニックネーム</td>
                  <td><input type="text" name="name"><span><?php echo $Ename; ?></span></td>
                </tr>
                <tr>
                  <td>ジャンル</td>
                  <td>
                    <select name="category">
                      <option value="0" selected>選択してください</option>
                      <option value="1">映画</option>
                      <option value="2">本</option>
                      <option value="3">音楽</option>
                    </select>
                    <span><?php echo $Ecategory; ?></span>
                  </td>
                </tr>
                <tr>
                  <td>メッセージ</td>
                  <td><textarea name="msg" rows="5"></textarea><span><?php echo $Emsg; ?></span></td>
                </tr>
                <tr>
                  <td>イメージ</td>
                  <td><input type="file" name="img"></td>
                </tr>
              </table>
              <table>
                <tr>
                  <td><label for="popup-on1" class="icon-close">キャンセル</label></td>
                  <td><button class="button" type="submit" name="post">ボミート</button></td>
                </tr>
              </table>
            </form>
          </div>
        </div><!-- ポップアップ部分 -->
    </div><!-- ボミートする -->

  </div><!-- ヘッダー -->



  <div id="content">
    <hr>
    <div id="timeline">
      <?php if(empty($fromData)): ?>
        <p>投稿はまだありません</p>
      <?php else: ?>
      <?php foreach($fromData as $val)://入ってる分ループ ?>
        <p><?php echo $val['id']; ?>　　　　　<?php echo $val['post_date']; ?>　　　<?php echo $val['category']; ?></p><!--ID,投稿日時,ジャンル-->
        <h2><?php echo $val['name']; ?></h2><br><!--ニックネーム-->
        <p><?php echo $val['msg']; ?></p><br><!--メッセージ-->
        <p><?php
            if(file_exists(UPLOAD_PATH.$val['id'].'.jpg')): ?>
              <img src="<?php echo UPLOAD_PATH.$val['id'].'.jpg'; ?>">
            <?php endif ?>
        </p><!--画像-->
        <form method="post">
          <button class="button" type="submit" name="delete" value="<?php echo $val['id']; ?>">削除</button>
        </form>
        <br><hr>
      <?php endforeach ?>
      <?php endif ?>
    </div><!-- タイムライン -->
  </div>

</div><!-- ラッパー -->
</body>

</html>