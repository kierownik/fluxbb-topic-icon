<?php

/**
************************************************************************
*  Author: kierownik
*  Date: 2013-06-15
*  Description: Adds Social links to the profile and viewtopic pages
*               where users can add their usernames.
*  Copyright (C) Daniel Rokven ( rokven@gmail.com )
*  License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
*
************************************************************************
**/

// Some info about your mod.
$mod_title      = 'Topic Icon';
$mod_version    = '1.0';
$release_date   = '2013-mm-dd';
$author         = 'Daniel Rokven';
$author_email   = 'rokven@gmail.com';

// Versions of FluxBB this mod was created for. A warning will be displayed, if versions do not match
$fluxbb_versions= array( '1.5.4', );

// Set this to FALSE if you haven't implemented the restore function (see below)
$mod_restore  = TRUE;

// We want the complete error message if the script fails
if ( !defined( 'PUN_DEBUG' ) )
  define( 'PUN_DEBUG', 1 );

// This following function will be called when the user presses the "Install" button
function install()
{
  global $db, $pun_config;

  // Schema to create the post_icon table
  $schema = array(
    'FIELDS'      => array(
      'id'        => array(
        'datatype'      => 'SERIAL',
        'allow_null'      => false
      ),
      'name'   => array(
        'datatype'      => 'VARCHAR( 200 )',
        'allow_null'    => false
      ),
      'filename'   => array(
        'datatype'      => 'VARCHAR( 200 )',
        'allow_null'    => false
      )
    ),
      'PRIMARY KEY'   => array( 'id' ),
      'INDEXES'     => array(
        'name_idx' => array( 'name' )
    )
  );

  // Create the post_icon table
  $db->create_table( 'topic_icon', $schema ) or error( 'Unable to create table "topic_icon"', __FILE__, __LINE__, $db->error() );

  // All the icons in one array to insert into the post_icon table
  $topic_icons = array(
    'Big Grin'    => 'biggrin.png',
    'Bug'         => 'bug.png',
    'Cake'        => 'cake.png',
    'Camera'      => 'camera.png',
    'Cancel'      => 'cancel.png',
    'Cd'          => 'cd.png',
    'Clock'       => 'clock.png',
    'Cog'         => 'cog.png',
    'Comment'     => 'comment.png',
    'Css'         => 'css.png',
    'Database'    => 'database.png',
    'Exclamation' => 'exclamation.png',
    'Heart'       => 'heart.png',
    'Information' => 'information.png',
    'Lightbulb'   => 'lightbulb.png',
    'Music'       => 'music.png',
    'Photo'       => 'photo.png',
    'Php'         => 'php.png',
    'Question'    => 'question.png',
    'Sad'         => 'sad.png',
    'Shocked'     => 'shocked.png',
    'Smile'       => 'smile.png',
    'Star'        => 'star.png',
    'Thumbs Down' => 'thumb_down.png',
    'Thumbs Up'   => 'thumb_up.png',
    'Tongue'      => 'tongue.png',
    'Video'       => 'video.png',
    'Wink'        => 'wink.png',
  );

  // Loop thru the $post_icons array to add them to the post_icon table
  foreach ( $topic_icons AS $key => $value )
  {
    $db->query( "INSERT INTO ".$db->prefix."topic_icon ( name, filename ) VALUES ( '$key', '$value' ) " ) or error( 'Unable to add "'.$key.'" to topic_icon table', __FILE__, __LINE__, $db->error() );
  }

  $allow_null = TRUE;
  $default_value = '0';
  $after_field = 'poster';

  // Add a new field to the posts table to hold the id of the icon
  $db->add_field( 'topics', 'topic_icon', 'int', $allow_null, $default_value, $after_field ) or error( 'Unable to add column "topic_icon" to table "topics"', __FILE__, __LINE__, $db->error() );

  // generate the post_icons cache
  require_once PUN_ROOT.'include/cache.php';
  require_once PUN_ROOT.'plugins/topic-icon/cache.php';
  generate_post_icon_cache();
}

// This following function will be called when the user presses the "Restore" button (only if $mod_restore is true (see above))
function restore()
{
  global $db, $db_type, $pun_config;

  // Drop the field post_icon from the posts table
  $db->drop_field( 'topics', 'topic_icon' ) or error( 'Unable to drop column "post_icon" from table "topics"', __FILE__, __LINE__, $db->error() );

  // Drop the table post_icon
  $db->drop_table( 'topic_icon' ) or error( 'Unable to drop table "post_icon"', __FILE__, __LINE__, $db->error() );

  // Clear the post_icons cache
  require_once PUN_ROOT.'include/cache.php';
  require_once PUN_ROOT.'plugins/topic-icon/cache.php';
  clear_post_icons_cache();
}

/***********************************************************************/

// DO NOT EDIT ANYTHING BELOW THIS LINE!


// Circumvent maintenance mode
define( 'PUN_TURN_OFF_MAINT', 1 );
define( 'PUN_ROOT', './' );
require PUN_ROOT.'include/common.php';

// We want the complete error message if the script fails
if ( !defined('PUN_DEBUG' ) )
  define( 'PUN_DEBUG', 1 );

// Make sure we are running a FluxBB version that this mod works with
$version_warning = !in_array( $pun_config['o_cur_version'], $fluxbb_versions );

$style = ( isset( $pun_user ) ) ? $pun_user['style'] : $pun_config['o_default_style'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo pun_htmlspecialchars($mod_title) ?> installation</title>
<link rel="stylesheet" type="text/css" href="style/<?php echo $style.'.css' ?>" />
</head>
<body>

<div id="punwrap">
<div id="puninstall" class="pun" style="margin: 10% 20% auto 20%">

<?php

if ( isset( $_POST['form_sent'] ) )
{
  if ( isset( $_POST['install'] ) )
  {
    // Run the install function ( defined above )
    install();

?>
<div class="block">
  <h2><span>Installation successful</span></h2>
  <div class="box">
    <div class="inbox">
      <p>Your database has been successfully prepared for <?php echo pun_htmlspecialchars( $mod_title ) ?>. See readme.txt for further instructions.</p>
    </div>
  </div>
</div>
<?php

  }
  else
  {
    // Run the restore function ( defined above )
    restore();

?>
<div class="block">
  <h2><span>Restore successful</span></h2>
  <div class="box">
    <div class="inbox">
      <p>Your database has been successfully restored.</p>
    </div>
  </div>
</div>
<?php

  }
}
else
{

?>
<div class="blockform">
  <h2><span>Mod installation</span></h2>
  <div class="box">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?foo=bar">
      <div><input type="hidden" name="form_sent" value="1" /></div>
      <div class="inform">
        <p>This script will update your database to work with the following modification:</p>
        <p><strong>Mod title:</strong> <?php echo pun_htmlspecialchars( $mod_title.' '.$mod_version ) ?></p>
        <p><strong>Author:</strong> <?php echo pun_htmlspecialchars( $author ) ?> (<a href="mailto:<?php echo pun_htmlspecialchars( $author_email ) ?>"><?php echo pun_htmlspecialchars( $author_email ) ?></a>)</p>
        <p><strong>Disclaimer:</strong> Mods are not officially supported by FluxBB. Mods generally can't be uninstalled without running SQL queries manually against the database. Make backups of all data you deem necessary before installing.</p>
<?php if ( $mod_restore ): ?>
        <p>If you've previously installed this mod and would like to uninstall it, you can click the Restore button below to restore the database.</p>
<?php endif; ?>
<?php if ( $version_warning ): ?>
        <p style="color: #a00"><strong>Warning:</strong> The mod you are about to install was not made specifically to support your current version of FluxBB (<?php echo $pun_config['o_cur_version']; ?>). This mod supports FluxBB versions: <?php echo pun_htmlspecialchars( implode( ', ', $fluxbb_versions ) ); ?>. If you are uncertain about installing the mod due to this potential version conflict, contact the mod author.</p>
<?php endif; ?>
      </div>
      <p class="buttons"><input type="submit" name="install" value="Install" /><?php if ( $mod_restore ): ?><input type="submit" name="restore" value="Restore" /><?php endif; ?></p>
    </form>
  </div>
</div>
<?php

}

?>

</div>
</div>

</body>
</html>
<?php

// End the transaction
$db->end_transaction();

// Close the db connection ( and free up any result data )
$db->close();