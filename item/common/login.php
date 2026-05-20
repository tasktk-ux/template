<?
function login_sub($pst){
	$sql = "SELECT * FROM admin WHERE ad_id = ? AND ad_pass = ?";
	$info = array($pst["cliant_key"], $pst["pass"]);
	$result = executeQuery($sql, $info);
	if($row = $result->fetch(PDO::FETCH_ASSOC)){
		# ログイン情報保持
		$_SESSION["ad_id"] = $row['ad_id'];
		$_SESSION["ad_pass"]    = $row['ad_pass'];
		$_SESSION["ad_auth"]    = $row['ad_auth'];
		# ログイン後のページ（メンバーのみに公開されるページ）
		$logout_url = URL_PATH;
		header("Location: {$logout_url}");
		exit;
		$error = '再度ログインしなおしてください。';
	}else{
		$error = 'ID or password is incorrect';
	}
	return($error);
}
?>