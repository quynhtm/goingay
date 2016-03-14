<?php
class SiteHeader extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/header.php';
		$this->add_form(new SiteHeaderForm());
	}
}