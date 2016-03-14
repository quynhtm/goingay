<?php
class SiteDetailNew extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteDetailNew.php';
		$this->add_form(new SiteDetailNewForm());
	}
}