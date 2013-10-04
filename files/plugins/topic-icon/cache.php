<?php

/**
 * Copyright (C) 2008-2012 FluxBB
 * based on code by Rickard Andersson copyright (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */

/**
************************************************************************
*  Author: kierownik
*  Date: 2013-06-15
*  Description: Adds post icons to the posts
*  Copyright (C) Daniel Rokven ( rokven@gmail.com )
*  License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
*
************************************************************************
**/

// Make sure no one attempts to run this script "directly"
if (!defined('PUN'))
	exit;


//
// Generate the config cache PHP script
//
function generate_post_icon_cache()
{
	global $db;

	// Get the forum config from the DB
	$result = $db->query('SELECT * FROM '.$db->prefix.'topic_icon', true) or error('Unable to fetch forum topic_icon', __FILE__, __LINE__, $db->error());

	$output = array();
	while ($cur_config_item = $db->fetch_row($result))
		$output[$cur_config_item[0]] = array( 'name' => $cur_config_item[1], 'filename' => $cur_config_item[2] );

	// Output config as PHP code
	$content = '<?php'."\n\n".'define(\'PUN_TOPIC_ICON_LOADED\', 1);'."\n\n".'$topic_icons = '.var_export($output, true).';'."\n\n".'?>';
	fluxbb_write_cache_file('cache_topic_icon.php', $content);
}

//
// Delete all feed caches
//
function clear_post_icons_cache()
{
	$d = dir(FORUM_CACHE_DIR);
	while (($entry = $d->read()) !== false)
	{
		if (substr($entry, 0, 16) == 'cache_topic_icon' && substr($entry, -4) == '.php')
			@unlink(FORUM_CACHE_DIR.$entry);
	}
	$d->close();
}
