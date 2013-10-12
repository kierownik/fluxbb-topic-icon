<?php

/**
************************************************************************
*  Author: kierownik
*  Date: 2013-06-15
*  Description: Adds an icon to the first post of the topic
*  Copyright (C) Daniel Rokven ( rokven@gmail.com )
*  License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
*
************************************************************************
**/

// Make sure no one attempts to run this script "directly"
if ( !defined( 'PUN' ) )
{
  exit;
}

// Load cached topic_icon
if ( !defined( 'PUN_TOPIC_ICON_LOADED') )
{
  if ( file_exists( FORUM_CACHE_DIR.'cache_topic_icon.php' ) )
  {
    include FORUM_CACHE_DIR.'cache_topic_icon.php';
  }
  else
  {
    require_once PUN_ROOT.'plugins/topic-icon/cache.php';

    generate_topic_icon_cache();
    include FORUM_CACHE_DIR.'cache_topic_icon.php';
  }
}

if ( !function_exists( 'generate_topic_icon_img_markup' ) )
{
  function generate_topic_icon_img_markup ( $ti_id )
  {
    global $topic_icons;

    if ( array_key_exists( $ti_id, $topic_icons ) )
    {
      $base_url = get_base_url( true );
      $filename = !empty( $ti_id ) ? $topic_icons[$ti_id]['filename'] : '';

      $ti_img = '<img src="'.pun_htmlspecialchars( $base_url.'/plugins/topic-icon/icons/'.$filename ).'" alt="'.$filename.'" /> ';
    }
    else
    {
      $ti_img = '';
    }

    return $ti_img;
  }
}

?>