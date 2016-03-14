<?php 
class AdminOrder extends Module{
	function AdminOrder($row){
		Module::Module($row);
		if(User::is_sale()){
			$cmd=Url::get('act');
			switch ($cmd){
				case 'delete':
					$id = (int)Url::get('id',0);
					if($id){
						DB::update ( TABLE_CART, array('del_flag'=>1), 'id='. $id);
					}
					Url::redirect_current();
					break;
				case 'status':
					$id = (int)Url::get('id',0);
					$status = (int)Url::get('status',0);
					if($id){
						DB::update ( TABLE_CART, array('status'=>($status == 1)? 0 : 1), 'id='. $id);
					}
					Url::redirect_current();
					break;
				default:
				require_once 'forms/listOrder.php';
				$this->add_form(new listOrderForm());
			}
		}
		else {
            Url::redirect('admin');
		}
	}
}