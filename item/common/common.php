<?
///////////////////////
//改行削除
///////////////////////
function v($val){
	return str_replace(array("\r\n","\n","\r"), '', $val);
}
///////////////////////
//改行変換
///////////////////////
function v2($val){
	return str_replace(array("\r\n","\n","\r"), '<br>', $val);
}
///////////////////////
//エスケープ
///////////////////////
function h($str){
	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

///////////////////////
//ログインチェック
///////////////////////
function login_chk($login_id){
	//ログイン判定
	if(!empty($login_id) == "" ){
		//ログイン認証していない場合は強制遷移
		$logout_url = URL_PATH . "login.html";
		header("Location: {$logout_url}");
	}
}
///////////////////////
//URL変換
///////////////////////
//function makeLink($value){
//文中のURLをリンクタグに置き換えて返却
//return mb_ereg_replace("(https?|ftp)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)", '<a href="\\1\\2" target="_blank">\\1\\2</a>' , $value);

//}
function makeLink($text) {
    // 1. 「」「」/『』『』/｛｝ で囲まれたラベルとURLの間に改行や空白があるパターンにも対応
    $text = preg_replace_callback(
        '/([「『｛{])([^「」『』｛｝{}]+)([」』｝}])\s*\n?\s*(https?:\/\/[^\s<>"\'()]+)/u',
        function ($matches) {
            $open = $matches[1];
            $label = h($matches[2]);
            $close = $matches[3];
            $url = h($matches[4]);

            // target指定：『』『』、「」「」 → _blank、それ以外（｛｝）はなし
            if (($open === '「' && $close === '」') || ($open === '『' && $close === '』')) {
                return '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $label . '</a>';
            } elseif ($open === '｛' && $close === '｝') {
                return '<a href="' . $url . '">' . $label . '</a>';
            }

            return $matches[0]; // 万一囲みが不一致ならスルー
        },
        $text
    );

    // 2. 裸URLリンク化の正規表現修正：直前にhref=や"がないことをチェックしつつ、
    // URLの後ろの日本語などはリンクに含めないようにする
    $text = preg_replace_callback(
        '/(?<!href="|">|\])\b(https?:\/\/[^\s<>"\'()｛｝「」『』]+)/i',
        function ($matches) {
            $url = h($matches[1]);
            return '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $url . '</a>';
        },
        $text
    );

    return $text;
}