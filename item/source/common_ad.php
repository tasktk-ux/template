<?
/////////////////////////////////////////////////////////////////////////////////
///[st_header]各ページ用のメタソースを記述させる
///
///まず、moduleディレクトリの「page_meta.dat」で
///ページ指標、ページタイトルページディスクリプションを定義しておくこと
///呼び出しもとで、ページ指標を引数に設定し、関数を呼び出し。
///タグ要素は仕様によって変更可。
/////////////////////////////////////////////////////////////////////////////////
function st_header_ad(){

//定数展開用ラムダ
$_ = function($s){return $s;};


	#ヘッダー情報を編集
$text=
<<<EOT
<!doctype html>
<!--[if IE 8]><html class="lt-ie9" lang="ja"><![endif]-->
<!--[if gt IE 8]><!--><html lang="ja"><!--<![endif]-->
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="robots" content="noindex">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
	<link rel="shortcut icon" href="images/favicon.png">
	<script defer src="{$_(URL_PATH)}item/submitForm.js"></script>
	<link rel="stylesheet" href="{$_(URL_PATH)}item/css.css" />
	<title>Fragments</title>
</head>

EOT;

#返却
return ($text);
}



/////////////////////////////////////////////////////////////////////////////////
///[hp_header]各ページ用のメタソースを記述させる
///
///タグ要素は仕様によって変更可。
///ページ数やディレクトリ構成によるdefineの変更や追加には要対応
/////////////////////////////////////////////////////////////////////////////////
function hp_header_ad(){

//定数展開用ラムダ
$_ = function($s){return $s;};
$add_menu='';
if(isset($_SESSION["ad_id"]) AND $_SESSION["ad_id"]<>""){
	$add_menu.='		<a href="'.URL_PATH.'frg_temp_memo.html" class="logout">&#128221;</a>'.PHP_EOL;
#	$add_menu.='		<a href="'.URL_PATH.'profile.html" class="logout">&#x1F4D6;</a>'.PHP_EOL;
	$add_menu.='		<a href="'.URL_PATH.'logout.html" class="logout">&#9166;</a>'.PHP_EOL;
}
$img_url = URL_PATH."images/";
$text=
<<<EOT
	<header>
		<h1><a href="{$_(URL_PATH)}"><img src="{$img_url}logo.png" width="250px"></a>
		{$add_menu}
		</h1>

EOT;

return ($text);

}

/////////////////////////////////////////////////////////////////////////////////
///[hp_footer]各ページ用のヘッダーソースを記述させる
/////////////////////////////////////////////////////////////////////////////////
function hp_footer_ad(){

//定数展開用ラムダ
$_ = function($s){return $s;};

	#フッター情報を編集
$text=
<<<EOT
	<!-- footer 
	================================================== -->
	<footer>
			<p>Copyright&copy;for myself<br>- It's private so you can use it freely -</p>
	</footer><!-- / #top-footer -->

EOT;

return ($text);

}



/////////////////////////////////////////////////////////////////////////////////
///メニュー用
/////////////////////////////////////////////////////////////////////////////////
function site_menu(){
	//定数展開用ラムダ
$_ = function($s){return $s;};
$ct_st=ctgr_sort_select();
$html_text=
<<<EOT
	<div>
		<details>
		<summary>Data extraction</summary>
		<form method="GET" action="{$_(URL_PATH)}">
			<ul>
				<li>
					<select name="frg_sw">
						<option value="">sw</option>
						<option value="1">open</option>
						<option value="9">close</option>
					</select>
				</li>
				<li>
{$ct_st}
				</li>
				<li><input type="text" name="srch_wd" placeholder="search word"/></li>
				<li>
					<select name="ind_dt">
						<option value="">ins_sort</option>
						<option value="ASC">ASC</option>
						<option value="DESC">DESC</option>
					</select>
				</li>
				<li>
					<select name="upd_dt">
						<option value="">upd_sort</option>
						<option value="ASC">ASC</option>
						<option value="DESC">DESC</option>
					</select>
				</li>
				<li>
					<input type="submit" value="Submit" />
					<input type="hidden" value="Submit" />
				</li>
			</ul>
		</form>
		</details>
	</div><!-- / .common-block -->
	</header><!-- / #site-header -->
	<hr>

EOT;

	return($html_text);
}