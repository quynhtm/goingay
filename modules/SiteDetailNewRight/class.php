<?php
class SiteDetailNewRight extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteDetailNewRight.php';
		$this->add_form(new SiteDetailNewRightForm());
	}
}