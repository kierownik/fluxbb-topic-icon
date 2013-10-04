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

// Load cached topic_icon
if ( !defined( 'PUN_TOPIC_ICON_LOADED') )
{
  if ( file_exists( FORUM_CACHE_DIR.'cache_topic_icon.php' ) )
  {
    include FORUM_CACHE_DIR.'cache_topic_icon.php';
  }
  else
  {
    if ( !defined( 'FORUM_CACHE_FUNCTIONS_LOADED' ) )
    {
      require_once PUN_ROOT.'include/cache.php';
    }
    require_once PUN_ROOT.'plugins/topic-icon/cache.php';

    generate_topic_icon_cache();
    include FORUM_CACHE_DIR.'cache_topic_icon.php';
  }
}
?>

<label for="topic_icon"><strong><?php echo $lang_ti['topic icon'] ?></strong></label>
<input type="radio" name="topic_icon" value="0" <?php echo ( empty( $topic_icon ) OR ( $topic_icon == '0' ) ) ? 'checked="checked"' : ''; ?>><?php echo $lang_ti['no icon'] ?><br />
<?php
$i = 1;
foreach ( $topic_icons AS $key => $value )
{
  ?>

		<input type="radio" name="topic_icon" value="<?php echo $key ?>" <?php echo ( isset( $topic_icon ) AND ( $topic_icon == $key ) ) ? 'checked="checked"' : ''; ?>>
    <img src="<?php echo get_base_url(true).'/plugins/topic-icon/icons/'.$value['filename'] ?>" alt="<?php echo $value['name'] ?>" />

  <?php
  echo ( $i % 14 == 0 ) ? '<br />' : '';
  $i++;
}
  ?>