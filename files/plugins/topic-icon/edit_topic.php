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

<label for="icon_id"><strong><?php echo $lang_ti['topic icon'] ?></strong></label>

<?php

if ( $icon_id != '0' AND !array_key_exists( $icon_id, $topic_icons ) )
{
  echo '<span style="color: red">'.$lang_ti['your topic icon does not exist anymore'].'</span><br />';
  $icon_id = '0';
}

?>
<input type="radio" name="icon_id" value="0"<?php echo $icon_id == '0' ? ' checked="checked"' : ''; ?>><?php echo $lang_ti['no icon'] ?><br />
<?php
$i = 1;
foreach ( $topic_icons AS $key => $value )
{

  ?>

		<input type="radio" name="icon_id" value="<?php echo $key ?>"<?php echo ( !empty( $icon_id ) AND ( $icon_id == $key ) ) ? ' checked="checked"' : ''; ?>>
    <img src="<?php echo pun_htmlspecialchars( get_base_url( true ) ).'/plugins/topic-icon/icons/'.$value['filename'] ?>" alt="<?php echo pun_htmlspecialchars( $value['name'] ) ?>" title="<?php echo pun_htmlspecialchars( $value['name'] ) ?>" />

  <?php

  echo ( $i % 14 == 0 ) ? '<br />' : '';
  $i++;
}
//echo print_r( $cur_post );
//echo '<br />'.$_POST['topic_icon'];
?>