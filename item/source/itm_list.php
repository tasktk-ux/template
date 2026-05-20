<?
////////////
//投稿一覧//
////////////
function frg_list($frg_sw,$frg_ctgr,$srch_wd,$ind_dt,$upd_dt,$page_num){
	//定数展開用ラムダ
	$_ = function($s){return $s;};

	$limit = 30;
	$keylist = array();
	
	//登録降順に展開（有効データのみ）
	$sql = 'SELECT * FROM fragments';
	$sql_add = "";

	//追加条件
		if(isset($frg_sw) and $frg_sw != ''){
			$sql_add.= " WHERE ";
			$sql_add.= "frg_sw = ?";
			$keylist[] = $frg_sw;
		}
		if(isset($frg_ctgr) and $frg_ctgr != ''){
			if($sql_add){$sql_add.= " AND ";}else{$sql_add.= " WHERE ";}
			$sql_add.= "frg_ctgr LIKE BINARY ?";
			$keylist[] = "%" .$frg_ctgr. "%";
		}
		if(isset($srch_wd) and $srch_wd != ''){
			if($sql_add){$sql_add.= " AND ";}else{$sql_add.= " WHERE ";}
			$sql_add.= "(frg_title LIKE BINARY ? or frg_fragments LIKE BINARY ?)";
			$keylist[] = "%" .$srch_wd. "%";
			$keylist[] = "%" .$srch_wd. "%";
		}
	
	
	$sql .= $sql_add;


	//SORT
		if(isset($ind_dt) and $ind_dt != ''){
			$sql.= ' ORDER BY frg_ins_date '.$ind_dt;
		}else{
			if(isset($upd_dt) and $upd_dt != ''){
				$sql.= ' ORDER BY frg_upd_date '.$upd_dt;
			}else{
				$sql .= ' ORDER BY frg_id DESC ';
			}
		}

	$sql .= ' LIMIT ? , ?';

	$keylist_cnt = array();
	$keylist_cnt = $keylist;
	$keylist[] = $page_num * $limit;
	$keylist[] = $limit;
	$result = executeQuery($sql, $keylist);
#ヘッダ
	$text=
<<<EOT
	<table>
		<tr>
			<th>title<a href="{$_(URL_PATH)}frg_detail_edt.html">[&plus;]</a>ctgr<a href="{$_(URL_PATH)}category.html">[&plus;]</a></th>
			<th>ins_date</th>
			<th>upd_date</th>
		</tr>

EOT;

#一覧生成
	$x=1;
	while($row = $result->fetch( PDO::FETCH_ASSOC ) ){
		$row["frg_ctgr"] = explode(',', $row["frg_ctgr"]);
		$ctgr = ctgr_selected($row["frg_ctgr"]);
		$text.=
<<<EOT
		<tr>
			<td class="t_left"><a href="{$_(URL_PATH)}frg_detail.html?frgid={$_($row['frg_id'])}">{$_($row['frg_title'])}</a><br>{$ctgr}</td>
			<td>{$_($row['frg_ins_date'])}</td>
			<td>{$_($row['frg_upd_date'])}</td>
		</tr>

EOT;
	$x++;
	}
		$text.=
<<<EOT
		</tr>
	</table>
	<hr>

EOT;
	//検索条件に該当する全データの件数取得
	$sql  = 'SELECT COUNT(*) FROM fragments';
	$sql .= $sql_add;
	$result = executeQuery($sql, $keylist_cnt);

	$cnt = $result->fetchColumn();

	//前の10件
	if ($page_num != 0) {
		$text.='		<a href="'.h(URL_PATH).'?page_num='. h($page_num - 1).'">＜－</a>'.PHP_EOL;
	}
	//ページ表示
	if($cnt > $limit) {
		$text.='		' . ($page_num + 1) . '/'. ceil($cnt / $limit) . ''.PHP_EOL;
	}
	//次の10件
	if (($page_num + 1)*$limit < $cnt) {
		$text.='		<a href="'.h(URL_PATH).'?&page_num='. h($page_num + 1) .'">－＞</a>'.PHP_EOL;
	}
	
	return($text);
	
}

////////////////
//カテゴリ一覧//
////////////////
function ctgr_list(){
	//定数展開用ラムダ
	$_ = function($s){return $s;};

	$limit = 50;
	$keylist = array();
	$text='';
	//登録降順に展開（有効データのみ）
	$sql = 'SELECT * FROM frg_category WHERE ctgr_sw = ? ORDER BY ctgr_id DESC';
	$keylist[] = 1;

	$result = executeQuery($sql, $keylist);
#ヘッダ

#一覧生成
	$x=1;
	while($row = $result->fetch( PDO::FETCH_ASSOC ) ){

		$text.=
<<<EOT
	<form action="" method="POST">
		<input type="text" name="ctgr_name" value="{$row["ctgr_name"]}">
		<label>Delete-><input type="checkbox" name="ctgr_sw" value="9"></label>
		<input type="hidden" name="ctgr_id" value="{$row["ctgr_id"]}?>">
		<input type="hidden" name="spls" value="do_news"/>
		<input type="submit" name="loginbtn" value="submit" class="login_btn"/>
	</form>

EOT;
	}

	$text.=
<<<EOT
	<form action="" method="POST">
		<input type="text" name="ctgr_name" required>
		<input type="hidden" name="spls" value="do_news"/>
		<input type="submit" name="loginbtn" value="submit" class="login_btn"/>
	</form>

EOT;

	return($text);
}


function ctgr_select($frg_ctgr){
	//定数展開用ラムダ
	$_ = function($s){return $s;};

	$limit = 50;
	$keylist = array();
	$text='';
	//登録降順に展開（有効データのみ）
	$sql = 'SELECT * FROM frg_category WHERE ctgr_sw = ? ORDER BY ctgr_id DESC';
	$keylist[] = 1;

	$result = executeQuery($sql, $keylist);
#ヘッダ

#一覧生成
	$x=1;
	while($row = $result->fetch( PDO::FETCH_ASSOC ) ){
		$chk='';
		foreach($frg_ctgr as $key => $value){
			if($value == $row['ctgr_id']){$chk=' checked';break;}
		}
		$text.='<label class="ctgr_sw"><input name="frg_ctgr[]" type="checkbox" value="'.h($row['ctgr_id']).'"'.$chk.'/>'.h($row['ctgr_name']).'</label>'.PHP_EOL;
	}
	return($text);
}


function ctgr_selected($frg_ctgr){
	//定数展開用ラムダ
	$_ = function($s){return $s;};

	$text='';
	foreach($frg_ctgr as $key => $value){
		$ctgr_data = ctgr_get($value);
		if(isset($ctgr_data['ctgr_name'])){
			$text.= '<span class="ctgr">'.h($ctgr_data['ctgr_name']).'</span>'.PHP_EOL;
		}
	}

	return($text);
}


function ctgr_sort_select(){
	//定数展開用ラムダ
	$_ = function($s){return $s;};

	$limit = 50;
	$keylist = array();
	$text='<select name="frg_ctgr">'.PHP_EOL;
	$text.='<option value="">Category</option>'.PHP_EOL;
	//登録降順に展開（有効データのみ）
	$sql = 'SELECT * FROM frg_category WHERE ctgr_sw = ? ORDER BY ctgr_id DESC';
	$keylist[] = 1;

	$result = executeQuery($sql, $keylist);
#ヘッダ

#一覧生成
	$x=1;
	while($row = $result->fetch( PDO::FETCH_ASSOC ) ){
		$text.='<option value="'.h($row['ctgr_id']).'">'.h($row['ctgr_name']).'</option>'.PHP_EOL;
	}
	$text.='</select>'.PHP_EOL;
	return($text);
}
