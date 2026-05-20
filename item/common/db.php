<?
# データベース接続・処理関数
	function executeQuery($sql, $stmt){
		#----- ↓変更して下さい↓ ------#
		$url  = DB_HOST_VL;  #MySqlサーバー名
		$user = DB_USER_VL;  #Myqlユーザー名
		$pass = DB_PASS_VL;  #Mysqlパスワード
		$db   = DB_NAME_VL;  #データベース名
		#------ ↑変更ここまで↑ -------#

		#MySQLへ接続する
		try {
			$dbh = new PDO("mysql:dbname=$db; host=$url", $user, $pass);
		} catch (PDOException $e) {
			exit('データベースに接続できませんでした。' . $e -> getMessage());
		}
		#キャラクタセット
		$dbh->query("SET NAMES utf8");
	
		# クエリを送信する
		# 文を実行する準備を行う
		$result = $dbh->prepare($sql);
		# 文を実行
		if ($stmt != '') {
			# bindValueを実行
			for ($i = 1; $i <= count($stmt); $i++) {
				if (is_string($stmt[$i-1])) {
					$result->bindValue($i, $stmt[$i-1], PDO::PARAM_STR);
				} else {
					$result->bindValue($i, $stmt[$i-1], PDO::PARAM_INT);
				}
			}
			$result->execute() or die("クエリの送信に失敗しました1。<br />SQL:".$sql);
		} else {
			$result->execute() or die("クエリの送信に失敗しました2。<br />SQL:".$sql);
		}
		# MySQLへの接続を閉じる
		$dbh = null;
		#戻り値
		return($result);
	}
	
