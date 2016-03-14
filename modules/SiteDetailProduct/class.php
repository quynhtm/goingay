<?php
class SiteDetailProduct extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteDetailProduct.php';
		$this->add_form(new SiteDetailProductForm());
	}
}