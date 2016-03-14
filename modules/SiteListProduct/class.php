<?php
class SiteListProduct extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteListProduct.php';
		$this->add_form(new SiteListProductForm());
	}
}