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

// Load the topic-icon.php language file
if ( file_exists( PUN_ROOT.'plugins/topic-icon/lang/'.$pun_user['language'].'/topic-icon.php' ) )
{
  require PUN_ROOT.'plugins/topic-icon/lang/'.$pun_user['language'].'/topic-icon.php';
}
else
{
  require PUN_ROOT.'plugins/topic-icon/lang/English/topic-icon.php';
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

// Unserialize the $pun_config['o_topic_icon'] to get all the options
$ti_config = unserialize( $pun_config['o_topic_icon'] );
$guest_add_icon = intval( $ti_config['guests_can_add_icon'] );

if ( ( $pun_user['is_guest'] AND $guest_add_icon == '1' ) OR !$pun_user['is_guest'] )
{

  ?>

  <label><?php echo $lang_ti['topic icon'] ?></label>
  <input type="radio" name="icon_id" value="0" <?php echo ( empty( $icon_id ) OR ( $icon_id == '0' ) ) ? 'checked="checked"' : ''; ?> /><?php echo $lang_ti['no icon'] ?>

  <?php

  // Check to see if there is not 0 in the database
  if ( intval( $ti_config['icons_in_a_row'] ) != '0' )
  {
    $i = 1;
  }

  foreach ( $topic_icons AS $key => $value )
  {
    $id             = intval( $key );
    $base_url       = pun_htmlspecialchars( get_base_url( true ) );
    $filename       = pun_htmlspecialchars( $value['filename'] );
    $name           = pun_htmlspecialchars( $value['name'] );
    $icons_in_a_row = intval( $ti_config['icons_in_a_row'] );

    ?>

    <input type="radio" name="icon_id" title="<?php echo $name ?>" value="<?php echo $id ?>"<?php echo ( isset( $icon_id ) AND ( $icon_id == $id ) ) ? ' checked="checked"' : ''; ?> />
    <img src="<?php echo $base_url.'/plugins/topic-icon/icons/'.$filename ?>" alt="<?php echo $name ?>" title="<?php echo $name ?>" />

    <?php

    // Check how many icons in a row have to be
    // when 0 then everything should be in 1 row
    if ( $icons_in_a_row != '0' )
    {
      echo ( $i % $icons_in_a_row == 0 ) ? '<br />' : '';
      $i++;
    }
  }
}
else
{
  echo '<input type="hidden" name="icon_id" value="0" />';
}

?>