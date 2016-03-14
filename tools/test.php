<?php
	require_once '../core/config.php';//System Config...
	require_once '../core/Debug.php'; //System Debug...
	require_once '../core/Init.php';  //System Init...

        $action = FunctionLib::getParam('action');
        if ($action) {
                if ($action) {
                        switch ($action) {
                            case 'test_quynh':
                                test_quynh();
                                break;
                            case 'pass':
                                password();
                                break;
                        }

                }
        } else {
                echo 'nhập tag,action để vào thực thi';
        }
	
        function test_quynh() {
            // goi thu vien
            require_once(ROOT_PATH . 'includes/class_phpexcel/PHPExcel.php');
            require_once(ROOT_PATH . 'includes/class_phpexcel/PHPExcel/Reader/Excel2007.php');
            //require_once(ROOT_PATH . 'includes/class_phpexcel/Classes/PHPExcel/php-excel.class.php');

        // xu ly export 
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
            $sheet->mergeCells('A1:G1');
            $sheet->setCellValue("A1", "Danh sách biểu đồ thống kê đang test");
            $sheet->getRowDimension("1")->setRowHeight(32);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                                                  ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // setting header
            $row = 3;
            $col = "A";
            $sheet->getRowDimension($row)->setRowHeight(30);
            $row_cells = array("STT",'Họ và tên', 'Danh mục');
            foreach ($row_cells as $cell) {
                $sheet->setCellValue($col . $row, $cell);
                $sheet->getStyle($col . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($col . $row)->getFont()->setSize(13)
                                                        ->getColor()->setRGB('FFFFFF');
                $sheet->getStyle($col . $row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '05729C')
                            ),
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '333333')
                                )
                            )
                        )
                );
                $col++;
            }
            $rowStart = ++$row;

            // output file name (doan nay toi save ra file, ong co the goi giong cai simlemat de no goi hop thoai donwload luon)
            $filename = "PH_DanhSachDangKy_" . date('Ymd').'.xls';
            @header('Content-type: text/html; charset=utf-8');
            @header("Content-Type: application/vnd.ms-excel");
            @header("Content-Disposition: attachment; filename={$filename}");
            @header("Cache-Control: max-age=0");
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel,'Excel5');
            $objWriter->save("php://output");
	}
        
        function password(){
            $password = Url::get('pass','');
            $id = Url::get('id',0);
            if($id > 0 && $password != ''){
                    DB::update_id('account', array('password'=>User::encode_password($password)), $id);
                    echo "update xong";
            }
	}
	
?>