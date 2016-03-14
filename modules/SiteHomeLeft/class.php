<?php
class SiteHomeLeft extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteHomeLeft.php';
		$this->add_form(new SiteHomeLeftForm());
	}
}