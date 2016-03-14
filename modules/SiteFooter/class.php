<?php
class SiteFooter extends Module
{
	function SiteFooter($row)
	{
		Module::Module($row);
		require_once 'forms/footer.php';
		$this->add_form(new SiteFooterForm);
	}
}
?>