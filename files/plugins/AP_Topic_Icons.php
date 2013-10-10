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

// Plugin version
define( 'PLUGIN_VERSION', '0.2.3' );

// Define the PLUGIN_URL
define( 'PLUGIN_URL', pun_htmlspecialchars( get_base_url( true ) ).'/admin_loader.php?plugin=AP_Topic_Icons.php' );

// Unserialize $ti_config
$ti_config = unserialize( $pun_config['o_topic_icon'] );

// allowed icon extensions
$allowed_extensions = $ti_config['allowed_extensions'];

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
    /*if ( !defined( 'FORUM_CACHE_FUNCTIONS_LOADED' ) )
    {
      require_once PUN_ROOT.'include/cache.php';
    }*/
    require_once PUN_ROOT.'plugins/topic-icon/cache.php';

    generate_topic_icon_cache();
    include FORUM_CACHE_DIR.'cache_topic_icon.php';
  }
}

//
// The rest is up to you!
//
if ( isset( $_POST['set_options'] ) )
{
  $ti_config = array(
    'icons_in_a_row'        =>  !empty( $_POST['icons_in_a_row'] ) ? intval( $_POST['icons_in_a_row'] ) : '0',
    'allowed_extensions'    =>  explode( ",", $_POST['allowed_extensions'] ),
    'guests_can_add_icon'   =>  !empty( $_POST['guests_can_add_icon'] ) ? intval( $_POST['guests_can_add_icon'] ) : '0',
  );

  if ( serialize( $ti_config ) != $pun_config['o_topic_icon'] )
  {
    $query = 'UPDATE `'.$db->prefix."config` SET `conf_value` = '".$db->escape( serialize( $ti_config ) )."' WHERE `conf_name` = 'o_topic_icon'";

    $db->query( $query ) or error( 'Unable to update board config post '. print_r( $db->error() ),__FILE__, __LINE__, $db->error() );

    // Regenerate the config cache
    require_once PUN_ROOT.'include/cache.php';
    generate_config_cache();
    redirect( PLUGIN_URL, $lang_ti['data saved'] );
  }
} // end edit_icon

//
// The rest is up to you!
//
if ( isset( $_POST['edit_icon'] ) )
{
  $icon_id = intval( $_POST['icon_id'] );
  if ( isset( $topic_icons[$icon_id] ) )
  {
    $icon = $topic_icons[$icon_id];
    if ( $_POST['icon_name'] != $topic_icons[$icon_id]['name'] OR $_POST['icon_filename'] != $topic_icons[$icon_id]['filename'] )
    {
      $query = 'UPDATE `'.$db->prefix."topic_icon` SET `name` = '".$db->escape( $_POST['icon_name'] )."', `filename` = '".$db->escape( $_POST['icon_filename'] )."' WHERE `id` = ".$icon_id."";

      $db->query( $query ) or error( 'Unable to update table topic_icon '. print_r( $db->error() ),__FILE__, __LINE__, $db->error() );

      // Regenerate the topic_icons cache
      require_once PUN_ROOT.'plugins/topic-icon/cache.php';
      generate_topic_icon_cache();
      redirect( PLUGIN_URL, $lang_ti['your icon has been changed'] );
    }
  }
}
// end edit_icon

// Add new icon
if ( isset( $_POST['add_icon'] ) )
{
  if ( !empty( $_POST['icon_name'] ) AND !empty( $_POST['icon_filename'] ) )
  {
    $query = 'INSERT INTO `'.$db->prefix."topic_icon` SET `name` = '".$db->escape( $_POST['icon_name'] )."', `filename` = '".$db->escape( $_POST['icon_filename'] )."'";

    $db->query( $query ) or error( 'Unable to add icon to the table topic_icon '. print_r( $db->error() ),__FILE__, __LINE__, $db->error() );

    // Regenerate the topic_icons cache
    require_once PUN_ROOT.'plugins/topic-icon/cache.php';
    generate_topic_icon_cache();
    redirect( PLUGIN_URL, $lang_ti['data saved'] );
  }
  else
  {
    generate_admin_menu( $plugin );
    message( $lang_ti['forgot something'] );
  }
}
// End add icon

// Delete the icon from the database
if ( isset( $_POST['delete_icon'] ) )
{
  $icon_id = intval( $_POST['icon_id'] );

  if ( array_key_exists( $icon_id, $topic_icons ) )
  {
    // Delete the topic icon from the database
    $query = 'DELETE FROM `'.$db->prefix.'topic_icon` WHERE `id` = '.$icon_id;

    $db->query( $query ) or error( 'Unable to delete icon from table topic_icon '. print_r( $db->error() ),__FILE__, __LINE__, $db->error() );

    // Begin delete the file icon
    $dir = PUN_ROOT.'/plugins/topic-icon/icons/';
    if ( file_exists( $dir.$topic_icons[$icon_id]['filename'] ) )
    {
      if ( !@unlink( $dir.$topic_icons[$icon_id]['filename'] ) )
      {
        generate_admin_menu( $plugin );
        message( $lang_ti['cannot delete file'] );
      }
    }
    // End delete the file icon

    // Regenerate the topic_icons cache
    require_once PUN_ROOT.'plugins/topic-icon/cache.php';
    generate_topic_icon_cache();
    redirect( PLUGIN_URL, $lang_ti['your icon has been deleted'] );
  }
}
// End delete_icon

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
      $icon_id = $topic_icons[$id];
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
      <form id="topic_icon" method="post" action="<?php echo PLUGIN_URL ?>">
        <input id="icon_id" name="icon_id" type="hidden" value="<?php echo $id ?>" />
        <table class="blocktable" style="border-spacing:0;border-collapse:collapse;">
          <tr>
            <td><label for="icon_name"><?php echo $lang_ti['name'] ?></label></td>
            <td><input id="icon_name" name="icon_name" type="text" value="<?php echo pun_htmlspecialchars( $icon_id['name'] ) ?>" /> <?php echo $lang_ti['name info'] ?></td>
          </tr>
          <tr>
            <td><label for="icon_filename"><?php echo $lang_ti['filename'] ?></label></td>
            <td><input id="icon_filename" name="icon_filename" type="text" value="<?php echo pun_htmlspecialchars( $icon_id['filename'] ) ?>" /> <?php echo $lang_ti['icon info'] ?></td>
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
      <form id="topic_icon" method="post" action="<?php echo PLUGIN_URL ?>">
        <input id="id" name="icon_id" type="hidden" value="<?php echo $id ?>" />
        <table class="blocktable" style="border-spacing:0;border-collapse:collapse;">
          <tr>
            <td><label for="icon_name"><?php echo $lang_ti['name'] ?></label></td>
            <td><input id="icon_name" name="icon_name" type="text" value="" /> <?php echo $lang_ti['name info'] ?></td>
          </tr>
          <tr>
            <td><label for="icon_filename"><?php echo $lang_ti['filename'] ?></label></td>
            <td><input id="icon_filename" name="icon_filename" type="text" value="<?php echo pun_htmlspecialchars( $_GET['icon'] ) ?>" /> <?php echo $lang_ti['icon info'] ?></td>
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
  if ( array_key_exists( $id, $topic_icons ) )
  {
    $icon_id = $topic_icons[$id];
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
      <form id="delete_icon" method="post" action="<?php echo PLUGIN_URL ?>">
        <input id="icon_id" name="icon_id" type="hidden" value="<?php echo $id ?>" />
        <p>
          <?php echo $lang_ti['delete topic icon confirm'] ?>
          <img src="<?php echo pun_htmlspecialchars( get_base_url( true ) ).'/plugins/topic-icon/icons/'.pun_htmlspecialchars( $icon_id['filename'] ) ?>" alt="<?php echo pun_htmlspecialchars( $icon_id['name'] ) ?>" />
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

?>

<div id="list_new_icons" class="blockform">
  <h2 class="block2"><span><?php echo $lang_ti['options'] ?></span></h2>
  <div class="box">
    <div class="inform">
      <form id="set_options" method="post" action="<?php echo PLUGIN_URL ?>">
        <p class="submittop">
          <input type="submit" name="set_options" value="<?php echo $lang_ti['save options'] ?>"/>
        </p>
        <table class="blocktable" style="border-spacing:0;border-collapse:collapse;">
          <tr>
            <td>
              <label for="icons_in_a_row"><?php echo $lang_ti['icons_in_a_row'] ?></label>
            </td>
            <td>
              <input type="text" id="icons_in_a_row" name="icons_in_a_row" value="<?php echo pun_htmlspecialchars( $ti_config['icons_in_a_row'] ) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <label for="allowed_extensions"><?php echo $lang_ti['allowed_extensions'] ?></label>
            </td>
            <td>
              <input type="text" id="allowed_extensions" name="allowed_extensions" value="<?php echo pun_htmlspecialchars( implode( ",", $ti_config['allowed_extensions'] ) ) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <label for="guests_can_add_icon"><?php echo $lang_ti['guests can add icon'] ?></label>
            </td>
            <td>
              <input type="radio" id="guests_can_add_icon" name="guests_can_add_icon" value="1"<?php echo intval( $ti_config['guests_can_add_icon'] ) == '1' ? ' checked="checked"' : '' ?> /><?php echo $lang_ti['yes'] ?>
              <input type="radio" id="guests_can_add_icon" name="guests_can_add_icon" value="0"<?php echo intval( $ti_config['guests_can_add_icon'] ) == '0' ? ' checked="checked"' : '' ?> /><?php echo $lang_ti['no'] ?>
            </td>
          </tr>
        </table>
        <p class="submittop">
          <input type="submit" name="set_options" value="<?php echo $lang_ti['save options'] ?>"/>
        </p>
      </form>
    </div>
  </div>
</div>

<?php

  // scan the dir for files that are not in the database yet
  $dir = PUN_ROOT.'/plugins/topic-icon/icons/';
  $dh  = opendir( $dir );
  while ( false !== ( $filename = readdir( $dh ) ) )
  {
    $ext = pathinfo( $filename, PATHINFO_EXTENSION );
    if ( in_array( $ext, $allowed_extensions ) )
    {
      $new_files[] = $filename;
    }
  }

  // filter out the filenames out of the cache so that we can compare them to the new ones
  $image_filename = array();
  foreach ( $topic_icons AS $icon_id => $value )
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
            <th><?php echo $lang_ti['actions'] ?></th>
          </tr>
        </thead>

          <?php

          // loop thru the array and show the new icon or icons
          foreach ( $files AS $filename )
          {
            $filename = pun_htmlspecialchars( $filename );

            ?>

          <tr>
            <td>
              <?php echo $filename ?>
            </td>
            <td>
              <img src="<?php echo pun_htmlspecialchars( get_base_url( true ) ).'/plugins/topic-icon/icons/'.$filename ?>" alt="<?php echo $filename ?>" />
            </td>
            <td>
              <a href="<?php echo PLUGIN_URL.'&amp;mode=add&amp;icon='.$filename ?>"><?php echo $lang_ti['add icon'] ?></a>
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

<div id="topic_icons_in_database" class="blockform">
  <h2 class="block2"><span><?php echo $lang_ti['topic icons'] ?></span></h2>
  <div class="box">
    <div class="inform">
      <table class="blocktable" style="border-spacing:0;border-collapse:collapse;">
        <thead>
        <tr>
          <th><?php echo $lang_ti['icon'] ?></th>
          <th><?php echo $lang_ti['name'] ?></th>
          <th><?php echo $lang_ti['filename'] ?></th>
          <th><?php echo $lang_ti['actions'] ?></th>
        </tr>
        </thead>

<?php

        foreach ( $topic_icons AS $icon_id => $value )
        {
          $icon_id = intval( $icon_id );

?>

        <tr>
          <td>
            <img src="<?php echo pun_htmlspecialchars( get_base_url( true ) ).'/plugins/topic-icon/icons/'.pun_htmlspecialchars( $value['filename'] ) ?>" alt="<?php echo pun_htmlspecialchars( $value['name'] ) ?>" />
          </td>
          <td>
            <?php echo pun_htmlspecialchars( $value['name'] ) ?>
          </td>
          <td>
            <?php echo pun_htmlspecialchars( $value['filename'] ) ?>
          </td>
          <td>
            <a href="<?php echo PLUGIN_URL.'&amp;mode=edit&amp;id='.$icon_id ?>"><?php echo $lang_ti['edit'] ?></a> | <a href="<?php echo PLUGIN_URL.'&amp;mode=delete&amp;id='.$icon_id ?>"><?php echo $lang_ti['delete'] ?></a>
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