<?php
class SiteHomeRight extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteHomeRight.php';
		$this->add_form(new SiteHomeRightForm());
	}
}