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

?>

<label for="icon_id"><?php echo $lang_ti['topic icon'] ?></label>

<?php

// Unserialize the $pun_config['o_topic_icon'] to get all the options
$ti_config      = unserialize( $pun_config['o_topic_icon'] );

// Check to see that there is not 0 in the database
if ( intval( $ti_config['icons_in_a_row'] ) != '0' )
{
  $i = 1;
}

if ( $icon_id != '0' AND !array_key_exists( $icon_id, $topic_icons ) )
{
  echo '<span style="color: red">'.$lang_ti['your topic icon does not exist anymore'].'</span><br />';
  $icon_id = '0';
}

?>

<input type="radio" name="icon_id" value="0"<?php echo $icon_id == '0' ? ' checked="checked"' : ''; ?>><?php echo $lang_ti['no icon'] ?>

<?php

foreach ( $topic_icons AS $key => $value )
{

  ?>

  <input type="radio" name="icon_id" value="<?php echo $key ?>"<?php echo ( !empty( $icon_id ) AND ( $icon_id == $key ) ) ? ' checked="checked"' : ''; ?>>
  <img src="<?php echo pun_htmlspecialchars( get_base_url( true ) ).'/plugins/topic-icon/icons/'.pun_htmlspecialchars( $value['filename'] ) ?>" alt="<?php echo pun_htmlspecialchars( $value['name'] ) ?>" title="<?php echo pun_htmlspecialchars( $value['name'] ) ?>" />

  <?php

  // Check how many icons in a row have to be
  // when 0 then everything should be in 1 row
  if ( intval( $ti_config['icons_in_a_row'] ) != '0' )
  {
    echo ( $i % intval( $ti_config['icons_in_a_row'] ) == 0 ) ? '<br />' : '';
    $i++;
  }
}

?>