<?php
/*
###################################################################
#
#  gf_funcs/gen_funcs.php
#  Auteur : giefca - <giefca@hotmail.com> - www.gf-phpbb.com
#  Commencé le : 04/04/2004
#  Date de dernière modification : 04/04/2004
#
#  Description : Ce fichier contient les fonctions récurentes
#                utilisées dans mes scripts.
#
###################################################################
*/

// Fonction get_var
// Récupération des variables envoyées à la page
// $variable est un tableau qui contient la description
// de la variable a récupérer et les contrôles a effectuer.
// détail du tableau :
// 'name' = nom de la variable
// 'method' = provenance GET/POST/''
// 'default' = valeur par défaut de la variable
// 'intval' = si TRUE la variable doit être entière
// 'okvar' = liste des valeurs autorisées pour la variable.
//
// exemple :
/*
 $mode = get_var(array(
  'name'=>'mode',
  'intval'=>false,
  'method'=>'GET',
  'okvar'=>array('mode1','mode2'),
  'default'=>'rien'
   )
 );
*/
function get_var2($variable)
{
  global $HTTP_GET_VARS, $HTTP_POST_VARS ;
   $var = $variable['name'] ;
   $$var = ( isset($variable['default']) ) ? $variable['default'] : '' ;
   $method = ( isset($variable['method']) ) ? $variable['method'] : '' ;
   $default = ( isset($variable['default']) ) ? $variable['default'] : '' ;

   switch($method)
   {
	  case 'POST':
	  $$var = (isset($HTTP_POST_VARS[$var])) ? $HTTP_POST_VARS[$var] : $default;
	  break;
	  case 'GET' :
  	  $$var = (isset($HTTP_GET_VARS[$var])) ? $HTTP_GET_VARS[$var] : $default;
  	  break;
	  default:
  	  if(isset($HTTP_POST_VARS[$var]) || isset($HTTP_GET_VARS[$var]))
	  {
		$$var = (isset($HTTP_POST_VARS[$var])) ? $HTTP_POST_VARS[$var] : $HTTP_GET_VARS[$var];
	  }
   }  

   if ( isset($variable['intval']) and $variable['intval']) 
   {
     $$var = intval($$var);
   }
   
   if ( isset($variable['okvar']) )
   {
      if ( !in_array($$var,$variable['okvar']) )
	  {
	    $$var = $default ; 
	  }
   }
   
   return $$var ;
}


/*-------------------*/
// strip_htmlchars
// ------------------
function strip_htmlchars($t="")
{
	// l'utilisation de l'expression régulière évite deremplacer les &#xxx;
	$t = preg_replace("/&(?!#[0-9]+;)/s", '&amp;', $t );
	$t = str_replace( "<", "&lt;"  , $t );
	$t = str_replace( ">", "&gt;"  , $t );
	$t = str_replace( '"', "&quot;", $t );
	
	return $t;
}
	
/*-------------------------------------------------------------------------*/
// add_htmlchars
/*-------------------------------------------------------------------------*/
function add_htmlchars($t="")
{
	$t = str_replace( "&lt;"  , "<", $t );
	$t = str_replace( "&gt;"  , ">", $t );
	$t = str_replace( "&quot;", '"', $t );
	$t = str_replace( "&amp;" , "&", $t );
		
	return $t;
}

?>