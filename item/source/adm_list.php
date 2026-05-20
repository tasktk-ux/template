<?
//////////////
//登録サイド//
//////////////
function adm_list(){
	//定数展開用ラムダ
	$_ = function($s){return $s;};

	//登録降順に展開（有効データのみ）
	$sql = 'SELECT * FROM admin WHERE ad_auth != ?';

	$sql .= ' ORDER BY ad_id ASC';
	$keylist = array();
	$keylist[] = 9;

	$result = executeQuery($sql, $keylist);
#ヘッダ
$text=
<<<EOT
	<table>
		<tr>
			<th>ログインID</th>
			<th>権限</th>
		</tr>

EOT;

#作業タイトルの一覧生成
	while($row = $result->fetch( PDO::FETCH_ASSOC ) ){
	$text.=
<<<EOT
		<tr>
			<td><a href="{$_(URL_PATH)}adm_detail.html?adid={$_($row['ad_id'])}">{$_($row['ad_id'])}</a></td>
			<td>{$_($row['ad_auth'])}</td>
		</tr>

EOT;
	}
$text.=
<<<EOT
	</table>

EOT;

	
	return($text);
}

