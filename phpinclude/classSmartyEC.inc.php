<?php

require_once('Smarty.class.php');
/**
 * This is the object to call up the Smarty Templates
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class SmartyEC extends Smarty
{
	function SmartyEC($basedir)
	{
		$this->Smarty();
		$this->template_dir = $basedir;
		if(!is_writable("$basedir/smarty_c"))
			die("$basedir/smarty_c must be writable");
		$this->compile_dir = "$basedir/smarty_c/";
		if(!is_writable("$basedir/smarty_cache"))
			die("$basedir/smarty_cache must be writable");
		$this->cache_dir = "$basedir/smarty_cache/";
		//$this->config_dir = '';
		$this->caching = true;
	}
}
?>
