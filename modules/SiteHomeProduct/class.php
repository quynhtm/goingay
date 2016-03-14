<?php
class SiteHomeProduct extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteHomeProduct.php';
		$this->add_form(new SiteHomeProductForm());
	}
}