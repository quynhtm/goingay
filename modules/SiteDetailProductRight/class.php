<?php
class SiteDetailProductRight extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteDetailProductRight.php';
		$this->add_form(new SiteDetailProductRightForm());
	}
}