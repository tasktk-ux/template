<?
//==================================================//
//
//メモテーブル
//
//==================================================//
	//メモ情報取得
	function list_get($frg_id){
		$sql  = "SELECT * FROM fragments WHERE frg_id = ?";
		$info = array($frg_id);
		$result = executeQuery($sql, $info);
		$row = $result->fetch( PDO::FETCH_ASSOC);
		return($row);
	}
	//メモ情報のアップロード判定
	function list_db_ld($pst){
		if($pst['frg_id']){
			$list_data = list_get($pst['frg_id']);
			if($list_data['frg_id']){
				list_upd($pst ,$file);
				$frg_id = "";
			}else{
				$frg_id = list_inst($pst);
			}
		}else{
			$frg_id = list_inst($pst);
		}
	}
	//メモ情報更新
	function list_upd($pst){
		//データ登録
		$sql  = "UPDATE fragments SET frg_sw = ?, frg_ctgr = ?, frg_title = ?, frg_fragments = ?, frg_upd_date = ? WHERE frg_id = ?";
		$info = array($pst["frg_sw"],$pst["frg_ctgr"],$pst["frg_title"],$pst["frg_fragments"],date("Y-m-d"),$pst["frg_id"]);
		$result = executeQuery($sql, $info);
		return($result);
	}
	//メモ情報追加
	function list_inst($pst){
		
		//データ登録
		$sql  = "INSERT INTO fragments (frg_sw, frg_ctgr, frg_title, frg_fragments, frg_ins_date) VALUES(?,?,?,?,?)";
		$info = array($pst["frg_sw"],$pst["frg_ctgr"],$pst["frg_title"],$pst["frg_fragments"],date("Y-m-d"));

		$result = executeQuery($sql, $info);
		return($result);
	}


//==================================================//
//
//カテゴリテーブル
//
//==================================================//
	//案件情報取得
	function ctgr_get($ctgr_id){
		$sql  = "SELECT * FROM frg_category WHERE ctgr_id = ?";
		$info = array($ctgr_id);
		$result = executeQuery($sql, $info);
		$row = $result->fetch( PDO::FETCH_ASSOC);
		return($row);
	}
	//案件情報のアップロード判定
	function ctgr_db_ld($pst){
		if($pst['ctgr_id']){
			$ctgr_data = ctgr_get($pst['ctgr_id']);
			if($ctgr_data['ctgr_id']){
				ctgr_upd($pst ,$file);
				$ctgr_id = "";
			}else{
				$ctgr_id = ctgr_inst($pst);
			}
		}else{
			$ctgr_id = ctgr_inst($pst);
		}
	}
	//案件情報更新
	function ctgr_upd($pst){
		//データ登録
		$sql  = "UPDATE frg_category SET ctgr_sw = ?, ctgr_name = ? WHERE ctgr_id = ?";
		$info = array($pst["ctgr_sw"],$pst["ctgr_name"],$pst["ctgr_id"]);
		$result = executeQuery($sql, $info);
		return($result);
	}
	//案件情報追加
	function ctgr_inst($pst){
		
		//データ登録
		$sql  = "INSERT INTO frg_category (ctgr_sw, ctgr_name) VALUES(?,?)";
		$info = array($pst["ctgr_sw"],$pst["ctgr_name"]);

		$result = executeQuery($sql, $info);
		return($result);
	}

//==================================================//
//
//メモテーブル(TEMP)
//
//==================================================//
	//メモ情報取得
	function temp_get($frg_temp_id){
		$sql  = "SELECT * FROM frg_temp_memo WHERE frg_temp_id = ?";
		$info = array($frg_temp_id);
		$result = executeQuery($sql, $info);
		$row = $result->fetch( PDO::FETCH_ASSOC);
		return($row);
	}
	//メモ情報のアップロード判定
	function temp_db_ld($pst){
		if($pst['frg_temp_id']){
			$temp_data = temp_get($pst['frg_temp_id']);
			if($temp_data['frg_temp_id']){
				temp_upd($pst ,$file);
				$frg_temp_id = "";
			}else{
				$frg_temp_id = temp_inst($pst);
			}
		}else{
			$frg_temp_id = temp_inst($pst);
		}
	}
	//メモ情報更新
	function temp_upd($pst){
		//データ登録
		$sql  = "UPDATE frg_temp_memo SET frg_temp_txt = ? WHERE frg_temp_id = ?";
		$info = array($pst["frg_temp_txt"],$pst["frg_temp_id"]);
		$result = executeQuery($sql, $info);
		return($result);
	}
	//メモ情報追加
	function temp_inst($pst){
		
		//データ登録
		$sql  = "INSERT INTO frg_temp_memo (frg_temp_sw, frg_temp_ctgr, frg_temp_title, frg_temp_fragments, frg_temp_ins_date) VALUES(?,?,?,?,?)";
		$info = array($pst["frg_temp_sw"],$pst["frg_temp_ctgr"],$pst["frg_temp_title"],$pst["frg_temp_fragments"],date("Y-m-d"));

		$result = executeQuery($sql, $info);
		return($result);
	}


//==================================================//
//
//ログイン情報操作（作業内訳）
//パスワードの暗号化などが必要だがテスト用なので省略
//
//==================================================//
	//ログイン情報取得
	function ad_get($ad_id){
		$sql  = "SELECT * FROM admin WHERE ad_id = ?";
		$info = array($ad_id);
		$result = executeQuery($sql, $info);
		$row = $result->fetch( PDO::FETCH_ASSOC);
		return($row);
	}
	//ログイン情報のアップロード判定
	function ad_db_ld($pst){
		if($pst['ad_id']){
			$ad_data = ad_get($pst['ad_id']);
			if($ad_data['ad_id']){
				if($pst['ad_pass']==""){$pst['ad_pass']=$ad_data['ad_pass'];}#パスワード入力が無い場合は既存パスワードのまま
				ad_upd($pst);
				$ad_id = "";
			}else{
				if($pst['ad_pass']==""){$pst['ad_pass']=$pst['ad_id'];}#パスワード入力が無い場合はログインIDと同様にする
				$ad_id = ad_inst($pst);
			}
		}else{
			if($pst['ad_pass']==""){$pst['ad_pass']=$pst['ad_id'];}#パスワード入力が無い場合はログインIDと同様にする
			$ad_id = ad_inst($pst);
		}
	}
	//ログイン情報更新
	function ad_upd($pst){
		//データ登録
		$sql  = "UPDATE admin SET ad_pass = ? ,ad_auth = ? ,ad_mail = ? WHERE ad_id = ?";
		$info = array($pst["ad_pass"],$pst["ad_auth"],$pst["ad_mail"],$pst["ad_id"]);
		$result = executeQuery($sql, $info);
		return($result);
	}
	//ログイン情報追加
	function ad_inst($pst){
		//データ登録
		$sql  = "INSERT INTO admin (ad_id, ad_pass, ad_auth, ad_mail) VALUES(?,?,?,?)";
		$info = array($pst["ad_id"], $pst["ad_pass"], $pst["ad_auth"], $pst["ad_mail"]);

		$result = executeQuery($sql, $info);
		return($ad_id);
	}


