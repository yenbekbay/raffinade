<?php
/*
Plugin Name: Stop IE6 
Description: This plugin identifies if a visitor is using Internet Explorer 6 (or older) and suggests to upgrade to a recent browser.
Author: Alen Cvitkovic
Version: 1.03
Author URI: http://www.alencvitkovic.com/
*/

function detection()
{
	if (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'], $version))
	{
		if ($version[1] < '8')
		{
			return true;
		}
			
		else if ($version[1] == '9')
		{
		
		}
	}
	
	return false;
}

function redirect_if_needed()
{
	if (detection())
	{
		include('errorPage.php');
		exit;	
	}
}

add_action('template_redirect', 'redirect_if_needed');

?>