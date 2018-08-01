<?php
class Template_Mod extends Template
{

	/*
	 * Définit le répertoire des templates à utiliser
	 */
	function Template_Mod()
	{
		$this->set_rootdir($phpbb_root_path . 'gf_portail/gf_mods/templates/');
	}
	
	/**
	 * Retourne le code compilé d'un module sous forme
	 * d'une variable.
	 */	
	function pparse_mod($handle)
	{
		if (!$this->loadfile($handle))
		{
			die("Template->pparse(): Couldn't load template file for handle $handle");
		}

		// actually compile the template now.
		if (!isset($this -> compiled_code[$handle]) || empty($this -> compiled_code[$handle]))
		{
			// Actually compile the code now.
			$this->compiled_code[$handle] = $this->compile($this -> uncompiled_code[$handle] , true , "_ret");
		}

		// Run the compiled code.
		eval($this->compiled_code[$handle]) ;
		return $_ret ;
	}
}
?>