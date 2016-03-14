<?php
class SvCategoryLib {
	    
	/**
	 * Get category by id
	 *
	 * @author MinhNV
	 * Date 2011/07/24
	 * @param int $cat_id
	 * @return $aryCategory
	 */
	static  public  function getCategory($cat_id){
	    $aryCategory = array();
	    $sql = 'SELECT * FROM '.TABLE_CATEGORY.' WHERE `status` = 1 AND id = ' . $cat_id;
	    $aryCategory = DB::get_row($sql); //DB::fetch($sql);
	    return $aryCategory;
	}
	
	/**
	 * Function show category
	 *
	 * @author  MinhNV
	 * Date 2010/06/04
	 * @param int $max
	 * @param array $aryDataInput
	 * @return array $aryData
	 */
	public  function  showCategory($max, $aryDataInput) {
	    $aryData = array();
        if(is_array($aryDataInput) && count($aryDataInput) > 0) {
	        foreach ($aryDataInput as $k => $val) {
	            if((int)$val['parent_id'] == 0) {
	                $val['padding_left'] = 0;//(((int)$val['level'] - 1) * 20) ."px";
	                $aryData[] = $val;
	                $this->showSubCategory($val['id'], $max, $aryDataInput, $aryData);
	            }
	        }
	    }
	    return $aryData;
	}
	
	/**
	 * Function showSubCategory
	 *
	 * @author  MinhNV
	 * Date 2010/06/04
	 * @param int $cat_id
	 * @param int $max
	 * @param array $aryDataInput
	 * @param array $aryData
	 */
	private function showSubCategory($cat_id, $max, $aryDataInput, &$aryData) {
	    if($cat_id <= $max) {
    	    foreach ($aryDataInput as $chk => $chval) {
                if($chval['parent_id'] == $cat_id) {
                    $chval['padding_left'] = (((int)$chval['level'] - 1) * 20) ."px";
                    $aryData[] = $chval;
                    $this->showSubCategory($chval['id'], $max, $aryDataInput, $aryData);
                }
            }
	    }
	}
	
	/**
	 * Get category news
	 *
	 * @author MinhNV
	 * Date 2010/06/21
	 * @return $aryCategoryNews
	 */
	public function getCategoryNews() {
	    $aryCategoryNews = array();
	    
        //Get category news
		$sql = 'SELECT id, name, parent_id, description, level, position, status FROM sv_category_news ORDER BY level ASC, position ASC';
		$aryCategoryNews = DB::fetch_all($sql);
		
		//Get max parent_id
	    $sql = 'SELECT max(parent_id) FROM sv_category_news';/// WHERE status = 1';
	    $max = (int)DB::get_one($sql);
	
		if($max > 0) {
		    $aryCategoryNews = $this->showCategory($max, $aryCategoryNews);
		}
	    return $aryCategoryNews;
	}
	
	/**
	 * Get category product
	 *
	 * @author MinhNV
	 * Date 2010/06/21
	 * @return $aryCategoryProduct
	 */
	public function getCategoryProduct() {
	    $aryCategoryProduct = array();
	    
	    //phongct added permit
		$permit = '';
	    if(!User::is_admin()) {
	    	$permit = User::get_query_permit_cat();
	    }
	    
	    //Neu memcached chua co data thi lay tu DB
        //Get category news
		$sql = 'SELECT id, name, parent_id, description, level, position, status FROM so_category '.$permit.' ORDER BY level ASC, position ASC';

		$aryCategoryProduct = DB::fetch_all($sql);
		
		//Get max parent_id
	     $sql = 'SELECT max(parent_id) FROM so_category '.$permit.' ';/// WHERE status = 1';
	    $max = (int)DB::get_one($sql);
	
		if($max > 0) {
		    $aryCategoryProduct = $this->showCategory($max, $aryCategoryProduct);
		}
		
	    return $aryCategoryProduct;
	}
	
	/**
	 * @QuynhTM add 02/07/2010
	 * Get list product category
	 * @return unknown_type
	 */
	public function getListProductsCategory() {
	    $aryListProductsCategory = array();
	    
	    //Neu memcached chua co data thi lay tu DB
	    //Get category news
		$sql = 'SELECT id, name, parent_id, level FROM `sv_category` ORDER BY level ASC';
		$aryListProductsCategory = DB::fetch_all($sql);
		
		//Get max parent_id
	     $sql = 'SELECT max(parent_id) FROM `sv_category`';/// WHERE status = 1';
	    $max = (int)DB::get_one($sql);
	
		if($max > 0) {
		    $aryListProductsCategory = $this->showCategory($max, $aryListProductsCategory);
		}
		
	    return $aryListProductsCategory;
	}
	
	
	/**
	 * Get list nodes of category
	 *
	 * @author MinhNV
	 * Date 2010/06/22
	 * @param int $depart_id
	 * @param int $parent_id
	 * @return $aryNodes
	 */
	public function getListNodes($parent_id) {
	    $aryNodes = array();
	    
	    $permit = '';
	    if(!User::is_admin()) {
	    	$permit = User::get_query_permit_cat(false);
	    	$permit = ($permit == '') ? ' AND FALSE ' : " AND $permit ";
	    }
	    
	    $sql = 'SELECT id, name, parent_id, description, level, position, status FROM so_category WHERE status = 1  AND parent_id = ' . $parent_id . ' ' . $permit . ' ORDER BY position ASC';

	    $aryNodes = DB::fetch_array($sql);
	    
	    return $aryNodes;
	}
	
	/**
	 * Get category by id
	 *
	 * @author MinhNV
	 * Date 2010/06/22
	 * @param int $depart_id
	 * @param int $cat_id
	 * @return $aryCategory
	 */
	public function getCategoryById($cat_id){
	    $aryCategory = array();
	    
	    $sql = 'SELECT id, name, parent_id, description, level, position, status FROM so_category WHERE status = 1 AND id = ' . $cat_id;
	    $aryCategory = DB::fetch($sql);
	    
	    return $aryCategory;
	}
	
	/**
	 * Function update tree level 
	 *
	 * @param string $table
	 * @param int $cat_id
	 * @param int $level
	 */
	public function updateTreeLevelCategory($table, $cat_id, $level) {
	    $aryList = $this->getListNodes($cat_id);
	    if(is_array($aryList) && count($aryList) > 0) {
	        foreach ($aryList as $k => $v) {
	            DB::update($table, array('level'=>$level), 'id='.$v['id']);
	            $this->updateTreeLevelCategory($table, $v['id'], $level + 1);
	        }
	    }
	}
}