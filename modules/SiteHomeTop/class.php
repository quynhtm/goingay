<?php
class SiteHomeTop extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteHomeTop.php';
		$this->add_form(new SiteHomeTopForm());
	}
}