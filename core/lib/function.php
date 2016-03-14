<?php

// FUNCTION DATABASE MORE
//Function get ObjectList from database	
function loadObjectList($query_id, $key = '') {
	if (!($cur = $query_id)) {
		return null;
	}
	$array = array();
	while ($row = mysql_fetch_object($cur)) {
		if ($key) {
			$array[$row->$key] = $row;
		} else {
			$array[] = $row;
		}
	}
	mysql_free_result($cur);
	return $array;
}

// Function load one result from database
function loadResult($query_id) {
	if (!($cur = $query_id)) {
		return null;
	}
	$ret = null;
	if ($row = mysql_fetch_row($cur)) {
		$ret = $row[0];
	}
	mysql_free_result($cur);
	return $ret;
}

// LIB FUNCTION PRODUCTS
// Function Recursive to get one Category
function getTreeCat($id, &$arr, $arr1, $arr2 = null) {
	//print_r($arr1[$id]);
	if (!is_null($arr2)) {
		$arr[] = isset($arr2[$id]) ? $arr2[$id] : null;
	} else {
		$arr[] = $id;
	}
	if (isset($arr1[$id])) {
		if (is_array($arr1[$id]) and (count($arr1[$id]) > 0)) {
			for ($i = 0; $i < count($arr1[$id]); $i++) {
				getTreeCat($arr1[$id][$i], $arr, $arr1, $arr2);
			}
		}
	}
}

//Function recursive get all parent Ids
function getTreeParentCategory($category_id, &$results) {
	$arrTemp = array();
	if ($category_id) {
		$row = DB::select("so_products_category", "published=1 AND id='" . $category_id . "'");
		if (count($row)) {
			$arrTemp['id'] = $row['id'];
			$arrTemp['name'] = $row['name'];
			$results[] = $arrTemp;
			if ($row['parent_id']) {
				getTreeParentCategory($row['parent_id'], $results);
			}
		}
	}
}

// Function get all Category return Ojects List
function getTreeCatAll($id = 0, $where = '', $preTextName = '--- ') {
// Get category all
	$query = 'SELECT *  FROM  ' . TABLE_CATEGORY . ' ' . $where . ' ORDER BY `order`';
	$query_id = DB::query($query);

	$pcatrows = loadObjectList($query_id);
	$arrObjectCats = array();
	$arrTreeCats = array();
	foreach ($pcatrows as $pcatrow) {
		$pcatrow->textTitle = addTextChildCat($pcatrow->name, $pcatrow->level, $preTextName);
		$arrTreeCats[$pcatrow->parent_id][] = $pcatrow->id;
		$arrObjectCats[$pcatrow->id] = $pcatrow;
	}
	$arrTreeLists = array();
	if (!$id) {
		//Get All Category When not id
		if (count($arrTreeCats) > 0) {
			for ($i = 0; $i < count($arrTreeCats[0]); $i++) {
				getTreeCat($arrTreeCats[0][$i], $arrTreeLists, $arrTreeCats, $arrObjectCats);
			}
		}
	} else {
		//Get for all child of id and id
		getTreeCat($id, $arrTreeLists, $arrTreeCats, $arrObjectCats);
		array_shift($arrTreeLists);
	}
	return $arrTreeLists;
}

// Function get all Category return Ojects List
function getTreeCatNewsAll($id = 0, $where = '', $preTextName = '--- ') {
// Get category all
	$query = 'SELECT *  FROM  ' . TABLE_CATEGORY_NEWS . ' ' . $where . ' ORDER BY `order`'
	;
	$query_id = DB::query($query);

	$pcatrows = loadObjectList($query_id);
	$arrObjectCats = array();
	$arrTreeCats = array();
	foreach ($pcatrows as $pcatrow) {
		$pcatrow->textTitle = addTextChildCat($pcatrow->name, $pcatrow->level, $preTextName);
		$arrTreeCats[$pcatrow->parent_id][] = $pcatrow->id;
		$arrObjectCats[$pcatrow->id] = $pcatrow;
	}
	$arrTreeLists = array();
	if (!$id) {
		//Get All Category When not id
		if (count($arrTreeCats) > 0) {
			for ($i = 0; $i < count($arrTreeCats[0]); $i++) {
				getTreeCat($arrTreeCats[0][$i], $arrTreeLists, $arrTreeCats, $arrObjectCats);
			}
		}
	} else {
		//Get for all child of id and id
		getTreeCat($id, $arrTreeLists, $arrTreeCats, $arrObjectCats);
		array_shift($arrTreeLists);
	}
	return $arrTreeLists;
}

// Function Add Text Pre_fix for Category Name 
function addTextChildCat($name, $level, $text = '--- ') {
	for ($i = 0; $i < $level; $i++) {
		$name = $text . $name;
	}
	return $name;
}

function subval_sort($a, $subkey) {
		foreach ($a as $k => $v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		asort($b);
		foreach ($b as $key => $val) {
			$c[] = $a[$key];
		}
		return $c;
	}
//QuynhTM build menu header
function buildMenuHeader() {
	$query = 'SELECT id,level,name,parent_id,linkview,`order` FROM  ' . TABLE_CATEGORY . ' WHERE status = 1 ORDER BY parent_id asc,`order` desc';
	$query_id = DB::query($query);
	$arrList = array();
	if ($query_id) {
		while ($row = mysql_fetch_assoc($query_id)) {
			//$row['linkview'] = Url::build('list_news', array('cat_id'=> $row['id'], 'title'=> safe_title($row['name'])));// list các tin bài cùng danh mục
			$row['linkview'] = '';
			if($row['level'] == 1){
				$arrList[$row['id']] = $row;
			}else{
				if(isset($arrList[$row['parent_id']])){
					$arrList[$row['parent_id']]['sub'][] = $row;
				}
			}
			
		}
	}
	return subval_sort($arrList,'order');
}



?>