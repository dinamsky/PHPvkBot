<?php
define('__ROOT__', dirname(__FILE__)); 

$modules = ['scandir' => scandir(__ROOT__.'\modules', 1), 'path' => '\modules'];
$commands = ['scandir' => scandir(__ROOT__.'\commands', 1), 'path' => '\commands'];
$utils = ['scandir' => scandir(__ROOT__.'\utils', 1), 'path' => '\utils'];


autoload($commands);
autoload($modules);
autoload($utils);


function autoload($dirfiles)
{
	for ($i=0; $i < count($dirfiles['scandir'])-2; $i++)
	{ 
		if (substr(strrchr($dirfiles['scandir'][$i], '.'), 1) == "php")
		{
			require_once __ROOT__.$dirfiles["path"].'\\'.$dirfiles['scandir'][$i];
		}
	}
}

?>