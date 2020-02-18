<?php

$filename = "mission3-5.txt";
$name = @$_POST["name"];
$comment =@ $_POST["comment"];
$delete =  @$_POST["deleteNo"];
$date = date("Y/m/d H:i:s");
$editer=@$_POST["edit"];
$hidebefore=@$_POST["hidebefore"];
$pass1 = @$_POST["pass1"]; //コメント欄のパスワード
$pass2 = @$_POST["pass2"]; //削除欄のパスワード
$pass3 = @$_POST["pass3"];  //編集欄のパスワード
$newform=($name."<>".$comment."<>".$date."<>".$pass1."<>"."\n");
	
	
	
if(!empty($name & $comment) && isset($_POST["send_button"]) && !empty($pass1)){
//名前とコメントが入力されているときに実行
//パスワードが入力されている時に実行
		
if(empty($hidebefore)){
//編集モードではない時
//新規送信の場合
$fp = fopen($filename,"a");
if(file_exists($filename)){
//もしファイルが既にテキストにあったら
 $_array = file($filename);
 $c = end($_array);
$content = explode("<>",$c);
 $num = ($content[0]); 
}else{
$num =0;
}
$num++;
	
fwrite($fp,$num."<>".$newform);
fclose($fp); //ファイルに追記する処理がここまで

}elseif(!empty($hidebefore) && !empty($pass1)){
//編集モードの時
//パスワードが入力されている時
		
$lines = file($filename);
$fp = fopen($filename,"w"); //白紙化する
foreach($lines as $value){ //配列を一個ずつ確認
$form5 = explode("<>",$value);
if($form5[0] == $hidebefore){
//編集番号と投稿番号が一緒の時
//編集した内容にさしかえる
fwrite($fp,$hidebefore."<>".$newform);
}
if($form5[0] != $hidebefore){
//編集番号と投稿番号が一致しない時
//元々のデータを書き込む
fwrite($fp,$value);
}	
}	
fclose($fp);	
}//編集モードここまで
}elseif(!empty($name & $comment) && isset($_POST["send_button"]) && empty($pass1)){
echo "パスワードが入力されていません";

}



//削除フォーム
if(!empty($delete) && !empty($pass2)){
//削除番号が空ではなかった時に実行
//パスワードが入力されている時に実行

$lines = file($filename);	//ファイル内容の保存
$fp = fopen($filename, "w");	//ファイルの白紙化
foreach($lines as $line){	//1投稿ずつ確認
$form3 = explode("<>",$line);	//区切り文字で分割
if($form3[0] == $delete && $form3[4]==$pass2){
//番号が一致しているなら何もしない	
}else{  //番号が一致していないなら
 fwrite($fp, $line);	//元々のデータを書きこむ
}
}	//ループ終了
fclose($fp);
	
}elseif(!empty($delete) && empty($pass2))	{
echo "パスワードが入力されていません";
}


//編集フォーム
if(!empty($editer) && isset($_POST["tbutton"])){
//編集対象番号が表示されていれば
//パスワードがあっていれば
//配列変数に代入
 $lines = file($filename);
  
foreach($lines as $value){
$form4 = explode("<>",$value);
if($form4[0] == $editer && $form4[4]==$pass3){
//投稿番号が編集番号と一致した時
//パスワードが一致した時
$e_name=$form4[1];
$e_comment=$form4[2]; //フォームに表示させる変数
}//投稿番号のif文ここまで
elseif($form4[0] == $editer && $form4[4] !=$pass3){
echo "パスワードが間違っています";
$e_name="";
$e_comment="";
}//elseif文ここまで
}//foreachここまで
}//if文ここまで
?>
<br><br>
<form action="" method="post">

名前<input type="text" name="name" value="<?php if(!empty($editer) && isset($_POST["tbutton"])){echo $e_name;}?>">
<br>
コメント<input type="text" name="comment" value="
<?php if(!empty($editer) && isset($_POST["tbutton"])){echo $e_comment;}?>"><br>
<input type="hidden" name="hidebefore" value="<?php if(!empty($_POST["edit"]) && isset($_POST["tbutton"])){echo $editer;}?>">
パスワード<input type = "text" name="pass1">
<br>
<input type="submit" name="send_button" value="送信">
<br><br>

削除対象番号<input type="text" name="deleteNo">
<br>
パスワード<input type = "text" name="pass2">
<br>
<input type="submit" name="delete" value="削除">
<br><br>

編集対象番号<input type="text" name="edit">
<br>
パスワード<input type = "text" name="pass3" >
<br>
<input type="submit" name="tbutton" value="編集">

</form>
</html>

<?php
//掲示板表示処理
//ファイルを配列に格納
$lines=file($filename);
foreach($lines as $value){
$form2=explode("<>",$value);
		
echo $form2[0]." ";
echo $form2[1]." ";
echo $form2[2]." ";
echo $form2[3]."<br>";
		
}//foreach関数がここまで
?>
