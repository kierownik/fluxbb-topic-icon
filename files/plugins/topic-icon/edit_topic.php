<?php

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

<label for="topic_icon"><strong><?php echo $lang_ti['topic icon'] ?></strong></label>

<?php

if ( $topic_icon != '0' AND !array_key_exists( $topic_icon, $topic_icons ) )
{
  echo '<span style="color: red">Your topic icon does not exist anymore...</span><br />';
  $topic_icon = '0';
}

?>
<input type="radio" name="topic_icon" value="0"<?php echo $topic_icon == '0' ? ' checked="checked"' : ''; ?>><?php echo $lang_ti['no icon'] ?><br />
<?php
$i = 1;
foreach ( $topic_icons AS $key => $value )
{

  ?>

		<input type="radio" name="topic_icon" value="<?php echo $key ?>"<?php echo ( !empty( $topic_icon ) AND ( $topic_icon == $key ) ) ? ' checked="checked"' : ''; ?>>
    <img src="<?php echo get_base_url(true).'/plugins/topic-icon/icons/'.$value['filename'] ?>" alt="<?php echo $value['name'] ?>" />

  <?php

  echo ( $i % 14 == 0 ) ? '<br />' : '';
  $i++;
}
//echo print_r( $cur_post );
//echo '<br />'.$_POST['topic_icon'];
?>