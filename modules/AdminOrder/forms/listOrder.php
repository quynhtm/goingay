<?php
class listOrderForm extends Form {
	const ALL_STATUS_BILL = 1000;
    var $search = array();
	function __construct(){
		Form::Form('ListForm');
        $this->link_css('style/bootstrap/lib/datetimepicker_new/datetimepicker.css');
        $this->link_js('style/bootstrap/lib/datetimepicker_new/jquery.datetimepicker.js');
		require_once ROOT_PATH.'core/lib/function.php';
	}
	function draw(){
		global $display;
		$this->beginForm(false,'post',false,Url::build_current());

		$cond = self::buildCond();
		//Get all acount
		$aryBill = array();
		$total_row = 0;
		$total_row = DB::get_one("SELECT COUNT(id) FROM  ".TABLE_CART."  WHERE " . $cond);
		$paging = '';
		if($total_row > 0){
			$limit = '';
			$paging = SvPaging::pagingSE($limit, $total_row, CGlobal::$number_per_page, CGlobal::$number_pages_show, 'page_no', true);
			$sql = "SELECT * ";
			$sql .= "FROM ".TABLE_CART." WHERE ". $cond. " ORDER BY id DESC " . $limit ;
			$res = DB::query($sql);
			if($res) {
				$i = 0;
				while ($item = mysql_fetch_assoc($res)){
					$item['date'] = date('H:i d-m-Y', $item['date']);
					$item['link_detail'] = Url::build('detail_product', array('pro_id'=>$item ['product_id'], 'title'=>safe_title($item['product_name'])));
					$aryBill[$i] = $item;
					$i++;
				}
			}
		}
		
		// assign varible doi soat
        $page_no = Url::get('page_no',1);
        $display->add('paging', $paging);
        $display->add('total_row', $total_row);
        $display->add('items', $aryBill);
        $display->add('page', Url::get('page'));
        $display->add('stt', ($page_no-1)*CGlobal::$number_per_page);

        $display->add('search',	$this->search);
		$display->output('List');
		$this->endForm();
	}
	
	function buildCond(){
        $this->search['customer_name'] = $cus_name = Url::get('customer_name');
        $this->search['mobile_phone'] = $cus_mobile = Url::get('mobile_phone');
        $this->search['product_name'] = $pro_name = Url::get('product_name');
        $this->search['product_id'] = $product_id = Url::get('product_id');
        $this->search['category_id'] = $cat_product_id =  Url::get('category_id', 0);

		$start_date = 0;
		$end_date = 0;
        $this->search['start_date'] = Url::get('start_date', date('d-m-Y H:i', strtotime('-1 day')));
        $this->search['end_date'] = Url::get('end_date', date('d-m-Y H:i'));

        $date_from = Url::get('start_date', date('d-m-Y H:i', strtotime('-1 day')));
        $date_to = Url::get('end_date', date('d-m-Y H:i'));
		if($date_from != '' || $date_to != '') {
			if($date_from){
				$date_arr = explode('-', $date_from);
				if(isset($date_arr[0]) && isset($date_arr[1]) && isset($date_arr[2]))
				$start_date = mktime(0,0,0,(int)$date_arr[1],(int)$date_arr[0],(int)$date_arr[2]);
			}
			if($date_to){
				$date_arr = explode('-', $date_to);
				if(isset($date_arr[0]) && isset($date_arr[1]) && isset($date_arr[2]))
				$end_date = mktime(23,59,59,(int)$date_arr[1],(int)$date_arr[0],(int)$date_arr[2]);
			}
		}

		$cond ='';
		$cond .= ' del_flag = 0 ';



        $status = Url::get('status',-1);
        $this->search['status'] = EnBacLib::getOption(array(-1 => 'Tất cả') + CGlobal::$arrStatus, $status);
        if($status != -1 ) {
            $cond .=  ' AND status = '. $status .' ';
        }

        //Search theo ngay startdate
		/*if($start_date) {
			$cond .= ' AND `date` >=' . $start_date ;
		}

		//Search theo enddate
		if($end_date) {
			$cond .= ' AND `date` <=' . $end_date ;
		}*/
		
		//Search tên khách hàng
		if($cus_name != '') {
			$cond .= ' AND customer_name like "%' . trim($cus_name) .'%"';
		}

		//Search theo user_name
		if($pro_name != '') {
			$cond .= ' AND product_name like "%' . trim($pro_name) .'%"';
		}
		//Search theo user_name
		if($product_id != '' && (int)$product_id > 0) {
			$cond .= ' AND product_id =' . $product_id .'';
		}

		//Search theo mobile
		if($cus_mobile) {
			$cond .= ' AND `mobile_phone` ="' . trim($cus_mobile) .'"';	
		}

		//Search theo category
        ////Get all category_product
        $aryCatProduct = getTreeCatAll();
        $this->aryCatProduct = $aryCatProduct;

        $aryCatOption=array();
        $aryCatOption[0]='--- Root ---';
        foreach($aryCatProduct as $arrCategoryList){
            $aryCatOption[$arrCategoryList->id]=$arrCategoryList->textTitle;
        }
        $cat_product_id =  SvLib::getContion('category_id', $ckValue);
        $cat_product_id = Url::get('category_id',0);
        $this->search['category_id'] = EnBacLib::getOption(array(0 => 'Tất cả') + $aryCatOption, $cat_product_id);
		if($cat_product_id > 0) {
			$cond .= ' AND category_id =' . $cat_product_id;
		}
		return $cond;
	}

	function on_submit(){
		$cmd =  Url::get('cmd', '');
		switch( $cmd ) {
			case 'saveFileExcelNCC' :
				$this->exportExcel();
				break;
			case 'saveFileExcelClassified' :
				$this->exportExcelClassified();
				break;
		}
	}



	function exportExcel(){
		//require_once(ROOT_PATH ."core/FunctionLib.php");
		require_once(ROOT_PATH ."includes/PHPExcel180/PHPExcel/IOFactory.php");
		require_once(ROOT_PATH ."includes/PHPExcel180/PHPExcel.php");

		$objPHPExcel = new PHPExcel();

		$sheet = $objPHPExcel->getActiveSheet();
		$pageMargins = $sheet->getPageMargins();
		$margin = 0.8 / 2.54;
		$pageMargins->setTop($margin);
		$pageMargins->setBottom($margin);
		$pageMargins->setLeft($margin);
		$pageMargins->setRight($margin);

		// Set Orientation, size and scaling
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

		$aryStyleExcel = self::buildExcel();
		$default_border = $aryStyleExcel['default_border'];
		$style_header = $aryStyleExcel['style_header'];
		$ary_cell_attr = $aryStyleExcel['ary_cell_attr'];
		$ary_cell_attr_left = $aryStyleExcel['ary_cell_attr_left'];
		$ary_cell_attr_right = $aryStyleExcel['ary_cell_attr_right'];
		//set title
		$start = 1; $offset = 1;
		$sheet = array('title_data'=>"CHI TIẾT GIAO DỊCH",'col_start'=>'A','col_end'=>'H');
		$objPHPExcel->getActiveSheet()->setCellValue("{$sheet['col_start']}$start",$sheet['title_data']);
		$objPHPExcel->getActiveSheet()->mergeCells("{$sheet['col_start']}$start:{$sheet['col_end']}$offset");
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->applyFromArray($ary_cell_attr);
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->getFont()->setBold(true);

		$start++; $offset++;
		$sheet = array('title_data'=>'Kho xuất:','title_sheet'=>'','col_start'=>'A','col_end'=>'B');
		$objPHPExcel->getActiveSheet()->setCellValue("{$sheet['col_start']}$start",$sheet['title_data']);
		$objPHPExcel->getActiveSheet()->mergeCells("{$sheet['col_start']}$start:{$sheet['col_end']}$offset");
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->applyFromArray($ary_cell_attr_left);
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->getFont()->setBold(false);
		$objPHPExcel->getActiveSheet()->setTitle($sheet['title_sheet']);

		$sheet = array('title_data'=>'abc','title_sheet'=>'','col_start'=>'C','col_end'=>'E');
		$objPHPExcel->getActiveSheet()->setCellValue("{$sheet['col_start']}$start",$sheet['title_data']);
		$objPHPExcel->getActiveSheet()->mergeCells("{$sheet['col_start']}$start:{$sheet['col_end']}$offset");
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->applyFromArray($ary_cell_attr_left);
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setTitle($sheet['title_sheet']);

		$sheet = array('title_data'=>'Người xác nhận: ','title_sheet'=>'','col_start'=>'F','col_end'=>'H');
		$objPHPExcel->getActiveSheet()->setCellValue("{$sheet['col_start']}$start",$sheet['title_data']);
		$objPHPExcel->getActiveSheet()->mergeCells("{$sheet['col_start']}$start:{$sheet['col_end']}$offset");
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->applyFromArray($ary_cell_attr_left);
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->getFont()->setBold(false);
		$objPHPExcel->getActiveSheet()->setTitle($sheet['title_sheet']);

		$start++; $offset++;
		$sheet = array('title_data'=>'Kho nhận:','title_sheet'=>'','col_start'=>'A','col_end'=>'B');
		$objPHPExcel->getActiveSheet()->setCellValue("{$sheet['col_start']}$start",$sheet['title_data']);
		$objPHPExcel->getActiveSheet()->mergeCells("{$sheet['col_start']}$start:{$sheet['col_end']}$offset");
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->applyFromArray($ary_cell_attr_left);
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->getFont()->setBold(false);
		$objPHPExcel->getActiveSheet()->setTitle($sheet['title_sheet']);

		$sheet = array('title_data'=>'store_to_name','title_sheet'=>'','col_start'=>'C','col_end'=>'E');
		$objPHPExcel->getActiveSheet()->setCellValue("{$sheet['col_start']}$start",$sheet['title_data']);
		$objPHPExcel->getActiveSheet()->mergeCells("{$sheet['col_start']}$start:{$sheet['col_end']}$offset");
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->applyFromArray($ary_cell_attr_left);
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setTitle($sheet['title_sheet']);

		$sheet = array('title_data'=>'Ngày xác nhận: ','title_sheet'=>'','col_start'=>'F','col_end'=>'H');
		$objPHPExcel->getActiveSheet()->setCellValue("{$sheet['col_start']}$start",$sheet['title_data']);
		$objPHPExcel->getActiveSheet()->mergeCells("{$sheet['col_start']}$start:{$sheet['col_end']}$offset");
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->applyFromArray($ary_cell_attr_left);
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->getFont()->setBold(false);
		$objPHPExcel->getActiveSheet()->setTitle($sheet['title_sheet']);

		$start++; $offset++;
		$sheet = array('title_data'=>'Tổng số có: n sản phẩm','title_sheet'=>'','col_start'=>'A','col_end'=>'H');
		$objPHPExcel->getActiveSheet()->setCellValue("{$sheet['col_start']}$start",$sheet['title_data']);
		$objPHPExcel->getActiveSheet()->mergeCells("{$sheet['col_start']}$start:{$sheet['col_end']}$offset");
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->applyFromArray($ary_cell_attr_left);
		$objPHPExcel->getActiveSheet()->getStyle("{$sheet['col_start']}$start")->getFont()->setBold(false);
		$objPHPExcel->getActiveSheet()->setTitle($sheet['title_sheet']);

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=NAMDALAT" . date("_d/m/Y__H_i") . '.xls');
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("php://output");
		exit;
	}
	static function buildExcel(){
		$aryStyleExcel =array();
		$aryStyleExcel['default_border'] = $default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb'=>'000000')
		);
		$aryStyleExcel['style_header'] = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'33CCCC'),
			),
			'font' => array(
				'bold' => true,
			)
		);
		$aryStyleExcel['ary_cell_attr'] = array(
			'font' => array(
				'italic'    => false,
				'size'        => 10
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'       => true
			)
		);
		$aryStyleExcel['ary_cell_attr_left'] = array(
			'font' => array(
				'italic'    => false,
				'size'        => 10
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'       => true
			)
		);
		$aryStyleExcel['ary_cell_attr_right'] = array(
			'font' => array(
				'italic'    => false,
				'size'        => 10
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'       => true
			)
		);
		return $aryStyleExcel;
	}
}