<?php
class SiteListNews extends Module{
	function __construct($row){					
		Module::Module($row);
		require_once 'forms/SiteListNews.php';
		$this->add_form(new SiteListNewsForm());
	}
}