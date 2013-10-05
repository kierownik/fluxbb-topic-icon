<?php

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
if ( !defined( 'PUN' ) )
{
  exit;
}

// Plugin version
define( 'PLUGIN_VERSION', '1.0' );

// Define the PLUGIN_URL
define( 'PLUGIN_URL', get_base_url(true).'/admin_loader.php?plugin=AP_Topic_Icons.php' );

// allowed icon extensions
$allowed_extensions = array( "jpg","jpeg","png","gif" );

// Load the topic-icon.php language file
if ( file_exists( PUN_ROOT.'plugins/topic-icon/lang/'.$pun_user['language'].'/topic-icon.php' ) )
  require PUN_ROOT.'plugins/topic-icon/lang/'.$pun_user['language'].'/topic-icon.php';
else
  require PUN_ROOT.'plugins/topic-icon/lang/English/topic-icon.php';

// Tell admin_loader.php that this is indeed a plugin and that it is loaded
define( 'PUN_PLUGIN_LOADED', 1 );

/// Load cached topic_icon
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

//
// The rest is up to you!
//
if ( isset( $_POST['edit_icon'] ) )
{
  $updated = FALSE;

  if ( isset( $topic_icons[$_POST['icon_id']] ) )
  {
    $icon = $topic_icons[$_POST['icon_id']];
    if ( $_POST['icon_name'] != $icon['name'] OR $_POST['filename'] != $icon['filename'] )
    {
      $query = 'UPDATE `'.$db->prefix."topic_icon` SET `name` = '".$db->escape( pun_htmlspecialchars( $_POST['icon_name'] ) )."', `filename` = '".$db->escape( pun_htmlspecialchars($_POST['filename'] ) )."' WHERE `id` = '".$db->escape( pun_htmlspecialchars( $_POST['icon_id'] ) )."'";

      $db->query( $query ) or error( 'Unable to update table topic_icon '. print_r( $db->error() ),__FILE__, __LINE__, $db->error() );

      $updated = TRUE;
    }
  }

  if ( $updated )
  {
    // Regenerate the topic_icons cache
    require_once PUN_ROOT.'include/cache.php';
    require_once PUN_ROOT.'plugins/topic-icon/cache.php';
    generate_topic_icon_cache();
    redirect( PLUGIN_URL, $lang_ti['your icon has been changed'] );
  }
} // end edit_icon

// Add new icon
if ( isset( $_POST['add_icon'] ) )
{
  $updated = FALSE;

  if ( !empty( $_POST['icon_name'] ) AND !empty( $_POST['icon_filename'] ) )
  {
    $query = 'INSERT INTO `'.$db->prefix."topic_icon` SET `name` = '".$db->escape( pun_htmlspecialchars( $_POST['icon_name'] ) )."', `filename` = '".$db->escape( pun_htmlspecialchars( $_POST['icon_filename'] ) )."'";

      $db->query( $query ) or error( 'Unable to add icon to the table topic_icon '. print_r( $db->error() ),__FILE__, __LINE__, $db->error() );

      $updated = TRUE;
  }
  else
  {
    generate_admin_menu( $plugin );
    message( $lang_ti['forgot something'] );
  }

  if ( $updated )
  {
    // Regenerate the topic_icons cache
    require_once PUN_ROOT.'include/cache.php';
    require_once PUN_ROOT.'plugins/topic-icon/cache.php';
    generate_topic_icon_cache();
    redirect( PLUGIN_URL, $lang_ti['data saved'] );
  }
} // End add icon

// Delete the icon from the database
if ( isset( $_POST['delete_icon'] ) )
{
  $updated = FALSE;

  if ( isset( $topic_icons[$_POST['id']] ) )
  {
    $icon = $topic_icons[$_POST['id']];

    // Delete the topic icon from the database
    $query = 'DELETE FROM `'.$db->prefix."topic_icon` WHERE `id` = '".$db->escape( $_POST['id'] )."'";
    $db->query( $query ) or error( 'Unable to delete icon from table topic_icon '. print_r( $db->error() ),__FILE__, __LINE__, $db->error() );

    // Delete the file icon
    $d = dir( PUN_ROOT.'/plugins/topic-icon/icons/' );
    while ( ( $entry = $d->read() ) !== false )
    {
      if ( $entry === $icon['filename'] )
        @unlink( PUN_ROOT.'/plugins/topic-icon/icons/'.$entry );
    }
    $d->close();

    // Ok everything worked so $updated can be true now
    $updated = TRUE;
  }

  if ( $updated )
  {
    // Regenerate the topic_icons cache
    require_once PUN_ROOT.'include/cache.php';
    require_once PUN_ROOT.'plugins/topic-icon/cache.php';
    generate_topic_icon_cache();
    redirect( PLUGIN_URL, $lang_ti['your icon has been deleted'] );
  }
} // end delete_icon

  // Display the admin navigation menu
  generate_admin_menu( $plugin );

?>
<div id="exampleplugin" class="plugin blockform">
  <h2><span><?php echo $lang_ti['topic icon'] ?> - v<?php echo PLUGIN_VERSION ?></span></h2>
  <div class="box">
    <div class="inbox">
      <p><?php echo $lang_ti['topic icon info'] ?></p>
      <p><?php echo $lang_ti['add new topic icon info'] ?></p>
    </div>
  </div>
</div>
<?php

if ( isset( $_GET['mode'] ) )
{
  if ( $_GET['mode'] == 'edit' )
  {
    $id = intval( $_GET['id'] );
    if ( isset( $topic_icons[$id] ) )
    {
      $icon = $topic_icons[$id];
    }
    else
    {
      message( $lang_ti['icon does not exist'] );
    }

?>
<div id="edit_icon" class="blockform">
  <h2 class="block2"><span><?php echo $lang_ti['edit topic icon'] ?></span></h2>
  <div class="box">
    <div class="inform">
      <form id="post_icon" method="post" action="<?php echo PLUGIN_URL ?>">
        <input id="icon_id" name="icon_id" type="hidden" value="<?php echo $id ?>" />
        <table class="blocktable" style="border-spacing:0;border-collapse:collapse;">
          <tr>
            <td><label for="name"><?php echo $lang_ti['name'] ?></label></td>
            <td><input id="icon_name" name="icon_name" type="text" value="<?php echo $icon['name'] ?>" /> <?php echo $lang_ti['name info'] ?></td>
          </tr>
          <tr>
            <td><label for="filename"><?php echo $lang_ti['icon'] ?></label></td>
            <td><input id="filename" name="filename" type="text" value="<?php echo $icon['filename'] ?>" /> <?php echo $lang_ti['icon info'] ?></td>
          </tr>
        </table>
        <p class="submittop">
          <input type="submit" name="edit_icon" value="<?php echo $lang_ti['save icon'] ?>"/>
        </p>
      </form>
    </div>      <!-- end class="box" -->
  </div>        <!-- end class="inform -->
</div>

<?php
}
elseif ( $_GET['mode'] == 'add' )
{
?>
<div id="add_new_icon" class="blockform">
  <h2 class="block2"><span><?php echo $lang_ti['add topic icon'] ?></span></h2>
  <div class="box">
    <div class="inform">
      <form id="post_icon" method="post" action="<?php echo PLUGIN_URL ?>">
        <input id="id" name="icon_id" type="hidden" value="<?php echo $id ?>" />
        <table class="blocktable" style="border-spacing:0;border-collapse:collapse;">
          <tr>
            <td><label for="icon_name"><?php echo $lang_ti['name'] ?></label></td>
            <td><input id="icon_name" name="icon_name" type="text" value="" /> <?php echo $lang_ti['name info'] ?></td>
          </tr>
          <tr>
            <td><label for="icon_filename"><?php echo $lang_ti['icon'] ?></label></td>
            <td><input id="icon_filename" name="icon_filename" type="text" value="<?php echo $_GET['icon'] ?>" /> <?php echo $lang_ti['icon info'] ?></td>
          </tr>
        </table>
        <p class="submittop">
          <input type="submit" name="add_icon" value="<?php echo $lang_ti['add new icon'] ?>"/>
        </p>
      </form>
    </div>      <!-- end class="box" -->
  </div>        <!-- end class="inform -->
</div>

<?php
}
elseif ( $_GET['mode'] == 'delete' )
{
  $id = intval( $_GET['id'] );
  if ( isset( $topic_icons[$id] ) )
  {
    $icon = $topic_icons[$id];
  }
  else
  {
    message( $lang_ti['icon does not exist'] );
  }
?>

<div id="delete_icon" class="blockform">
  <h2 class="block2"><span><?php echo $lang_ti['delete topic icon'] ?></span></h2>
  <div class="box">
    <div class="inform">
      <form id="post_icon" method="post" action="<?php echo PLUGIN_URL ?>">
        <input id="id" name="id" type="hidden" value="<?php echo $id ?>" />
        <p>
          <?php echo $lang_ti['delete topic icon confirm'] ?>
          <img src="<?php echo get_base_url(true).'/plugins/topic-icon/icons/'.$icon['filename'] ?>" alt="<?php echo $icon['name'] ?>" />
        </p>
        <p class="submittop">
          <input type="submit" name="delete_icon" value="<?php echo $lang_ti['delete icon'] ?>"/>
        </p>
      </form>
    </div>      <!-- end class="box" -->
  </div>        <!-- end class="inform -->
</div>
<?php

  }
  else
  {
    generate_admin_menu( $plugin );
    message( $lang_ti['mode does not exist'] );
  }
}
else
{

  // scan the dir for files that are not in the database yet
  $dir = PUN_ROOT.'/plugins/topic-icon/icons/';
  $dh  = opendir( $dir );
  while ( false !== ( $filename = readdir( $dh ) ) )
  {
    $ext = pathinfo( $filename, PATHINFO_EXTENSION );
    if ( in_array( $ext, $allowed_extensions ) )
      $new_files[] = $filename;
  }

  // filter out the filenames out of the cache so that we can compare them to the new ones
  $image_filename = array();
  foreach ( $topic_icons AS $key => $value)
  {
    $image_filename[] = $value['filename'];
  }

  // if there are new files that are not in the database then this will tell us
  $files = array_diff( $new_files, $image_filename );

  if ( !empty( $files ) )
  {
    ?>

<div id="list_new_icons" class="blockform">
  <h2 class="block2"><span><?php echo $lang_ti['new topic icons'] ?></span></h2>
  <div class="box">
    <div class="inform">
      <div class="inbox">
        <p><?php echo $lang_ti['new topic icons info'] ?></p>
      </div>
      <table class="blocktable" style="border-spacing:0;border-collapse:collapse;">
        <thead>
          <tr>
            <th><?php echo $lang_ti['icon'] ?></th>
            <th><?php echo $lang_ti['name'] ?></th>
            <th><?php echo $lang_ti['controls'] ?></th>
          </tr>
        </thead>
          <?php

          // loop thru the array and show the new icon or icons
          foreach ( $files AS $key )
          {
            ?>

          <tr>
            <td>
              <?php echo $key ?>
            </td>
            <td>
              <img src="<?php echo get_base_url(true).'/plugins/topic-icon/icons/'.$key ?>" alt="<?php echo $key ?>" />
            </td>
            <td>
              <a href="<?php echo PLUGIN_URL.'&amp;mode=add&amp;icon='.$key ?>">Add image</a>
            </td>
          </tr>

            <?php
          }
            ?>

      </table>
    </div>        <!-- end class="inform" -->
  </div>        <!-- end class="box" -->
</div>        <!-- end class="blockform" -->

<?php
      }
?>

<div id="post_icons_in_database" class="blockform">
  <h2 class="block2"><span><?php echo $lang_ti['topic icons'] ?></span></h2>
  <div class="box">
    <div class="inform">
      <table class="blocktable" style="border-spacing:0;border-collapse:collapse;">
        <thead>
        <tr>
          <th><?php echo $lang_ti['icon'] ?></th>
          <th><?php echo $lang_ti['name'] ?></th>
          <th><?php echo $lang_ti['controls'] ?></th>
        </tr>
        </thead>
          <?php

        foreach ( $topic_icons AS $key => $value)
        {
          ?>

        <tr>
          <td>
            <img src="<?php echo get_base_url(true).'/plugins/topic-icon/icons/'.$value['filename'] ?>" alt="<?php echo $value['name'] ?>" />
          </td>
          <td>
            <?php echo $value['name'] ?>
          </td>
          <td>
            <a href="<?php echo PLUGIN_URL.'&amp;mode=edit&amp;id='.$key ?>"><?php echo $lang_ti['edit'] ?></a> | <a href="<?php echo PLUGIN_URL.'&amp;mode=delete&amp;id='.$key ?>"><?php echo $lang_ti['delete'] ?></a>
          </td>
        </tr>

          <?php
        }
          ?>

      </table>
    </div>      <!-- end class="inform" -->
  </div>      <!-- end class="box" -->
</div>        <!-- end class="blockform" -->

<?php
  }
?>