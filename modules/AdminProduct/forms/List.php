<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class ListForm extends Form {
	var $condition = array(),$aryCatPro = array(), $search = array(),$paramSearch = array(), $stringWhere = '', $page_no = 1, $offset = 0, $item_per_page = 0;
    var $aryTypeNews = array();
    var $arrHot = array(-1=>'Tin hot' ,1 => 'Có', 0 => "Không");
	function __construct() {
		Form::Form('ListForm');//dùng common
		$this->deleteItemError();
		$this->buildCondition();
        CGlobal::$website_title = 'Quản trị tin tức';
	}

    function on_submit(){
        $cmd =  Url::get('act', '');
        switch( $cmd ) {
            case 'export_excel' :
                $this->exportExcel();
                break;
        }
    }

    function deleteItemError(){
        $aryDataDelete = Product::getProductByCondition('images,id,images_other_temp',' status='.CGlobal::status_error,false);
        if (!empty($aryDataDelete)) {
            foreach($aryDataDelete as $id =>$item){
                Product::deleteItem($item);
            }
        }
    }
    function buildCondition() {
        //------------ SEARCH - SET AND GET FROM COOKIE -----------
        $cookieName = 'product_seach';
        $ckValue = (isset($_COOKIE[$cookieName]) ? unserialize($_COOKIE[$cookieName]) : array());

        $name_pro =  SvLib::getContion('name', $ckValue);
        $this->search['name'] = $name_pro;
        if($name_pro != '') {
            $this->condition[] = ' name like "%'.$name_pro.'%" ';
            $this->paramSearch['name'] = $name_pro;
        }

        $product_id =  SvLib::getContion('product_id', $ckValue);
        $this->search['product_id'] = $product_id;
        if($product_id != '') {
            $this->condition[] = ' id ='.$product_id.'';
            $this->paramSearch['product_id'] = $product_id;
        }

        //tim category
        $aryCatProduct = array();
        $this->aryCatPro = $aryCatProduct = getTreeCatAll();
        $aryCatOption = array();
        foreach($aryCatProduct as $arrCategoryList){
            $aryCatOption[$arrCategoryList->id]=$arrCategoryList->textTitle;
        }
        $cat_product_id =  SvLib::getContion('category_id', $ckValue);
        $this->search['category_id'] = EnBacLib::getOption(array(0 => 'Tất cả') + $aryCatOption, $cat_product_id);
        if($cat_product_id != 0 ) {
            $this->condition[] = ' category_id = '. $cat_product_id .' ';
            $this->paramSearch['category_id'] = $cat_product_id;
        }

        $status =  SvLib::getContion('status', $ckValue,-1);
        $this->search['status'] = EnBacLib::getOption(array(-1 => 'Tất cả') + CGlobal::$arrStatus, $status);
        if($status != -1 ) {
            $this->condition[] = ' status = '. $status .' ';
            $this->paramSearch['status'] = $status;
        }

        //paging
        $this->page_no =  SvLib::getContion('page_no', $ckValue, 1);
        $this->item_per_page =  SvLib::getContion('item_per_page', $ckValue, CGlobal::$number_per_page);
        $this->search['item_per_page'] = SvLib::item_per_page($this->item_per_page);
        $this->offset = ($this->page_no-1) * $this->item_per_page;

        //set cookie search 10 phút
        EnBacLib::set_cookie($cookieName, serialize($ckValue), TIME_NOW+600);

        //lay SP nguoi tao san pham
        if(!User::is_root() && CHECK_SHOP == 1){
            $this->condition[] = ' create_user_id = '. User::id() .' ';
        }
        $this->stringWhere = empty($this->condition) ? '' : ''.join(' AND ', $this->condition);
    }

	function draw() {
		global $display;
		$this->beginForm(false, 'post', false, Url::build_current());
        $page_no = Url::get('page_no',1);
		$total_row = ($this->stringWhere != '')? DB::count(Product::$table,$this->stringWhere) :  DB::count(Product::$table);
		$items = array();
		$paging = '';
		if ($total_row > 0) {
			$limit = '';
            $paging = SvPaging::getNewPager($limit,CGlobal::$number_pages_show, $page_no, $total_row, CGlobal::$number_per_page,$this->paramSearch);
			$sql = 'SELECT * FROM '.Product::$table;
			$sql .=  ($this->stringWhere != '') ? ' WHERE '. $this->stringWhere : ' ';
			$sql .= ' ORDER BY id desc';
			$sql .= $limit;
			
			$re = DB::query($sql);
			if ($re) {
				while ($row = mysql_fetch_assoc($re)) {
                    $row ['images_big'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_PRODUCT,300,150);
                    $row ['images'] = SvImg::getThumbImage($row['images'],$row['id'],SvImg::FOLDER_PRODUCT,40,40);

                    $row['create_time'] = date('d-m-Y', $row['create_time']);
                    $row['modify_time'] = ($row['modify_time'] > 0) ? date('d-m-Y', $row['modify_time']) : '';
                    $row['start_time'] = ($row['start_time'] > 0) ? date('d-m-Y H:i', $row['start_time']) : '';
                    $row['end_time'] = ($row['end_time'] > 0) ? date('d-m-Y H:i', $row['end_time']) : '';
					$items[$row['id']] = $row;
				}
			}
		}
        $page_no = Url::get('page_no',1);
		$display->add('paging', $paging);
		$display->add('total_row', $total_row);
		$display->add('items', $items);
		$display->add('page', Url::get('page'));
		$display->add('stt', ($page_no-1)*CGlobal::$number_per_page);

		//common
        $display->add('is_root',(User::is_root())? 1: 0);
        $display->add('is_manager',(User::is_manager())? 1: 0);
        $display->add('is_manager_product',(User::is_manager_product())? 1: 0);
        $display->add('is_edit_product',(User::is_edit_product())? 1: 0);
        $display->add('is_delete_product',(User::is_delete_product())? 1: 0);

		$display->add('title_page', 'Quản trị sản phẩm');
        $display->add('hover', EnBacLib::mouse_hover(COLOR_MOUSE_HOVER, true));
		$display->add('search',	$this->search);
		$display->output('List');
		$this->endForm();
	}

    //Xuất excel
    function getDataExportExcel(){
        $total_row = ($this->stringWhere != '')? DB::count(Product::$table,$this->stringWhere) :  DB::count(Product::$table);
        $items = array();
        if ($total_row) {
            $limit = '';
            $sql = 'SELECT * FROM '.Product::$table;
            $sql .=  ($this->stringWhere != '') ? ' WHERE '. $this->stringWhere : ' ';
            $sql .= ' ORDER BY id desc';
            $sql .= $limit;

            $re = DB::query($sql);
            if ($re) {
                while ($row = mysql_fetch_assoc($re)) {
                    $row['create_time'] = date('d-m-Y', $row['create_time']);
                    $row['modify_time'] = ($row['modify_time'] > 0) ? date('d-m-Y', $row['modify_time']) : '';
                    $row['start_time'] = ($row['start_time'] > 0) ? date('d-m-Y H:i', $row['start_time']) : '';
                    $row['end_time'] = ($row['end_time'] > 0) ? date('d-m-Y H:i', $row['end_time']) : '';
                    $items[] = $row;
                }
            }
        }
        return $items;
    }

    function exportExcel(){
        require_once(ROOT_PATH ."includes/PHPExcel180/PHPExcel/IOFactory.php");
        require_once(ROOT_PATH ."includes/PHPExcel180/PHPExcel.php");

        //lây du lieu
        $arrData = $this->getDataExportExcel();
        //SvLib::FunctionDebug($data);

        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue("A1", "Danh sách sản phẩm");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val10,'val'=>'Mã SP','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val35,'val'=>'Tên sản phẩm','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Giá nhập','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
            'E'=>array('w'=>$val18,'val'=>'Giá bán','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data['id']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['name']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('D'.$rowCount, $data['price_input']);

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('E'.$rowCount, $data['price']);

            $rowCount++;
        }

        //tính tổng tiền nếu có, hiển thị giá tiền theo định dạng
        $rowCount2 = $rowCount+1;
        $sheet->getStyle('C' . $rowCount2)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
        $sheet->getStyle('C' . $rowCount2)->getFont()->setBold(true);
        $sheet->setCellValue("C".$rowCount2, "Tổng tiền");

        //giá nhập
        $sheet->getStyle('D' . $rowCount2)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
        $sheet->getStyle('D' . $rowCount2)->getFont()->setBold(true);
        $sheet->SetCellValue('D' . $rowCount2, '=SUM(D4:D' . ($rowCount - 1) . ')');

        //giá bán
        $sheet->getStyle('E' . $rowCount2)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
        $sheet->getStyle('E' . $rowCount2)->getFont()->setBold(true);
        $sheet->SetCellValue('E' . $rowCount2, '=SUM(E4:E' . ($rowCount - 1) . ')');

        //hien thị giá tiền theo định dang
        $objPHPExcel->getActiveSheet()
            ->getStyle('D4:E' . $rowCount2)
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        // output file
        ob_clean();
        $filename = "DanhSachSanPham" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
    }
}
?>