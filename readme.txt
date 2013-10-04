##
##
##        Mod title:  Topic Icon 
##
##      Mod version:  1.0 
##   Works on PunBB:  1.5.4, 1.5.3 
##     Release date:  2013-MM-DD 
##           Author:  Adds an icons to the first post of the topic 
##
##      Description:  Adds an icons to the first post of the topic 
##
##       Affects DB:  Yes 
##
##   Affected files:  edit.php 
##                    moderate.php 
##                    post.php 
##                    search.php 
##                    viewforum.php 
##                    viewtopic.php 
##
##            Notes:  Please note that "mods" are not officially supported by FluxBB.
##                    Installation of this modification is done at  your own risk. Backup
##                    your forum database and any and all applicable files before proceeding. 
##
##       DISCLAIMER:  Please note that 'mods' are not officially supported by
##                    PunBB. Installation of this modification is done at your
##                    own risk. Backup your forum database and any and all
##                    applicable files before proceeding.
##


#
#---------[ 1. UPLOAD ]---------------------------------------------------
#

install_mod.php to /
files/ to /

#
#---------[ 2. RUN ]---------------------------------------------------
#

install_mod.php

#
#---------[ 3. DELETE ]---------------------------------------------------
#

install_mod.php

#
#---------[ 4. OPEN ]---------------------------------------------------
#

edit.php

#
#---------[ 5. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT f.id AS fid, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.id AS tid, t.subject, t.posted,

#
#---------[ 6. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT f.id AS fid, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.id AS tid, t.subject, t.posted, t.topic_icon,

#
#---------[ 7. FIND ]---------------------------------------------------
#

$errors = array();

#
#---------[ 8. AFTER, ADD ]---------------------------------------------------
#

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
// Set $topic_icon
// if $_POST['topic_icon'] isset then that takes precedence over $cur_post['topic_icon']
$topic_icon = isset( $_POST['topic_icon'] ) ? intval( $_POST['topic_icon'] ) : $cur_post['topic_icon'];


#
#---------[ 9. FIND ]---------------------------------------------------
#

$db->query('UPDATE '.$db->prefix.'topics SET subject=\''.$db->escape($subject).'\', sticky='.$stick_topic.' WHERE id='.$cur_post['tid'].' OR moved_to='.$cur_post['tid']) or error('Unable to update topic', __FILE__, __LINE__, $db->error());

#
#---------[ 10. REPLACE WITH ]---------------------------------------------------
#

$db->query('UPDATE '.$db->prefix.'topics SET topic_icon=\''.$db->escape($topic_icon).'\', subject=\''.$db->escape($subject).'\', sticky='.$stick_topic.' WHERE id='.$cur_post['tid'].' OR moved_to='.$cur_post['tid']) or error('Unable to update topic', __FILE__, __LINE__, $db->error());

#
#---------[ 11. FIND ]---------------------------------------------------
#

<li><span>»&#160;</span><a href="viewtopic.php?id=<?php echo $cur_post['tid'] ?>"><?php echo pun_htmlspecialchars($cur_post['subject']) ?></a></li>

#
#---------[ 12. REPLACE WITH ]---------------------------------------------------
#

<?php $icon = ( $topic_icon == '0' OR !array_key_exists( $topic_icon, $topic_icons ) ) ? '' : '<img src="'.get_base_url(true).'/plugins/topic-icon/icons/'.$topic_icons[$topic_icon]['filename'].'" alt="" /> '; ?>
<li><span>»&#160;</span><?php echo $icon ?><a href="viewtopic.php?id=<?php echo $cur_post['tid'] ?>"><?php echo pun_htmlspecialchars($cur_post['subject']) ?></a></li>

#
#---------[ 13. FIND ]---------------------------------------------------
#

<?php endif; ?>						<label class="required"><strong><?php echo $lang_common['Message'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />

#
#---------[ 14. REPLACE WITH ]---------------------------------------------------
#

<?php endif; 

if ( $cur_post['first_post_id'] == $_GET['id'] )
include ( PUN_ROOT.'/plugins/topic-icon/edit_topic.php' );

?>            <label class="required"><strong><?php echo $lang_common['Message'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />

#
#---------[ 15. OPEN ]---------------------------------------------------
#

moderate.php

#
#---------[ 16. FIND ]---------------------------------------------------
#

	$result = $db->query('SELECT t.subject,

#
#---------[ 17. REPLACE WITH ]---------------------------------------------------
#

	$result = $db->query('SELECT t.topic_icon, t.subject,

#
#---------[ 18. FIND ]---------------------------------------------------
#

			$db->query('INSERT INTO '.$db->prefix.'topics (poster, subject, posted, first_post_id, forum_id) VALUES (\''.$db->escape($first_post_data['poster']).'\', \''.$db->escape($new_subject).'\', '.$first_post_data['posted'].', '.$first_post_data['id'].', '.$move_to_forum.')') or error('Unable to create new topic', __FILE__, __LINE__, $db->error());

#
#---------[ 19. REPLACE WITH ]---------------------------------------------------
#

			$db->query('INSERT INTO '.$db->prefix.'topics (poster, topic_icon, subject, posted, first_post_id, forum_id) VALUES (\''.$db->escape($first_post_data['poster']).'\', \''.$db->escape($first_post_data['topic_icon']).'\', \''.$db->escape($new_subject).'\', '.$first_post_data['posted'].', '.$first_post_data['id'].', '.$move_to_forum.')') or error('Unable to create new topic', __FILE__, __LINE__, $db->error());

#
#---------[ 20. FIND ]---------------------------------------------------
#

	$result = $db->query('SELECT u.title, u.num_posts, g.g_id, g.g_user_title, p.id, p.poster,

#
#---------[ 21. REPLACE WITH ]---------------------------------------------------
#

	$result = $db->query('SELECT u.title, u.num_posts, g.g_id, g.g_user_title, p.id, p.topic_icon, p.poster,

#
#---------[ 22. FIND ]---------------------------------------------------
#

				$result = $db->query('SELECT poster, subject,

#
#---------[ 23. REPLACE WITH ]---------------------------------------------------
#

				$result = $db->query('SELECT poster, topic_icon, subject,

#
#---------[ 24. FIND ]---------------------------------------------------
#

	$result = $db->query('SELECT id, poster, subject,

#
#---------[ 25. REPLACE WITH ]---------------------------------------------------
#

	$result = $db->query('SELECT id, poster, topic_icon, subject,

#
#---------[ 26. FIND ]---------------------------------------------------
#

		// Insert the status text before the subject

#
#---------[ 27. BEFORE, ADD ]---------------------------------------------------
#

    $icon = array();

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
      $icon[$cur_topic['id']] = ( ( isset( $cur_topic['topic_icon'] ) AND ( $cur_topic['topic_icon'] == '0' ) ) OR !array_key_exists( $cur_topic['topic_icon'], $topic_icons ) ) ? '' : '<img src="'.get_base_url(true).'/plugins/topic-icon/icons/'.$topic_icons[$cur_topic['topic_icon']]['filename'].'" alt="" /> ';

      if ( isset( $icon[$cur_topic['id']] ) AND $icon[$cur_topic['id']] != '' )
        $subject = implode(' ', $icon).' '.$subject;

#
#---------[ 28. OPEN ]---------------------------------------------------
#

post.php

#
#---------[ 29. FIND ]---------------------------------------------------
#

	$result = $db->query('SELECT f.id, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.subject,

#
#---------[ 30. REPLACE WITH ]---------------------------------------------------
#

	$result = $db->query('SELECT f.id, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.topic_icon, t.subject,

#
#---------[ 31. FIND ]---------------------------------------------------
#

// Did someone just hit "Submit" or "Preview"?

#
#---------[ 32. BEFORE, ADD ]---------------------------------------------------
#

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
  // Set $topic_icon
  $topic_icon = !empty( $_POST['topic_icon'] ) ? intval( $_POST['topic_icon'] ) : '';

#
#---------[ 33. FIND ]---------------------------------------------------
#

			$db->query('INSERT INTO '.$db->prefix.'topics (poster, subject, posted, last_post, last_poster, sticky, forum_id) VALUES(\''.$db->escape($username).'\', \''.$db->escape($subject).'\', '.$now.', '.$now.', \''.$db->escape($username).'\', '.$stick_topic.', '.$fid.')') or error('Unable to create topic', __FILE__, __LINE__, $db->error());

#
#---------[ 34. REPLACE WITH ]---------------------------------------------------
#

			$db->query('INSERT INTO '.$db->prefix.'topics (poster, topic_icon, subject, posted, last_post, last_poster, sticky, forum_id) VALUES(\''.$db->escape($username).'\', \''.$db->escape($topic_icon).'\', \''.$db->escape($subject).'\', '.$now.', '.$now.', \''.$db->escape($username).'\', '.$stick_topic.', '.$fid.')') or error('Unable to create topic', __FILE__, __LINE__, $db->error());

#
#---------[ 35. FIND ]---------------------------------------------------
#

<?php if (isset($cur_posting['subject'])): ?>     <li><span>»&#160;</span><a href="viewtopic.php?id=<?php echo $tid ?>"><?php echo pun_htmlspecialchars($cur_posting['subject']) ?></a></li>

#
#---------[ 36. BEFORE, ADD ]---------------------------------------------------
#

			<?php $icon = ( !isset( $_POST['topic_icon'] ) OR empty( $_POST['topic_icon'] ) ) ? '' : '<img src="'.get_base_url(true).'/plugins/topic-icon/icons/'.$topic_icons[$_POST['topic_icon']]['filename'].'" alt="" /> '; ?>

#
#---------[ 37. FIND ]---------------------------------------------------
#

<?php endif; ?>     <li><span>»&#160;</span><strong><?php echo $action ?></strong></li>

#
#---------[ 38. REPLACE WITH ]---------------------------------------------------
#

<?php endif; ?>			<li><span>?&#160;</span><?php echo $icon ?><strong><?php echo $action ?></strong></li>

#
#---------[ 39. FIND ]---------------------------------------------------
#

<?php endif; ?>						<label class="required"><strong><?php echo $lang_common['Message'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />

#
#---------[ 40. REPLACE WITH ]---------------------------------------------------
#

<?php endif; 

if ($fid)
	include ( PUN_ROOT.'/plugins/topic-icon/add_topic.php' );

?>						<label class="required"><strong><?php echo $lang_common['Message'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />

#
#---------[ 41. OPEN ]---------------------------------------------------
#

search.php

#
#---------[ 42. FIND ]---------------------------------------------------
#

								$result = $db->query('SELECT p.id AS post_id, p.topic_id,

#
#---------[ 43. REPLACE WITH ]---------------------------------------------------
#

								$result = $db->query('SELECT p.id AS post_id, t.topic_icon, p.topic_id,

#
#---------[ 44. FIND ]---------------------------------------------------
#

								$result = $db->query('SELECT m.post_id, p.topic_id,

#
#---------[ 45. REPLACE WITH ]---------------------------------------------------
#

								$result = $db->query('SELECT m.post_id, t.topic_icon, p.topic_id,

#
#---------[ 46. FIND ]---------------------------------------------------
#

					$result = $db->query('SELECT p.id AS post_id, p.topic_id FROM

#
#---------[ 47. REPLACE WITH ]---------------------------------------------------
#

					$result = $db->query('SELECT p.id AS post_id, p.topic_id, t.topic_icon FROM

#
#---------[ 48. FIND ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id FROM

#
#---------[ 49. REPLACE WITH ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id, t.topic_icon FROM

#
#---------[ 50. FIND ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id FROM

#
#---------[ 51. REPLACE WITH ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id, t.topic_icon FROM

#
#---------[ 52. FIND ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id FROM

#
#---------[ 53. REPLACE WITH ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id, t.topic_icon FROM

#
#---------[ 54. FIND ]---------------------------------------------------
#

				$result = $db->query('SELECT p.id FROM

#
#---------[ 55. REPLACE WITH ]---------------------------------------------------
#

				$result = $db->query('SELECT p.id, t.topic_icon FROM

#
#---------[ 56. FIND ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id FROM

#
#---------[ 57. REPLACE WITH ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id, t.topic_icon FROM

#
#---------[ 58. FIND ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id FROM

#
#---------[ 59. REPLACE WITH ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id, t.topic_icon FROM

#
#---------[ 60. FIND ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id FROM

#
#---------[ 61. REPLACE WITH ]---------------------------------------------------
#

				$result = $db->query('SELECT t.id, t.topic_icon FROM

#
#---------[ 62. FIND ]---------------------------------------------------
#

			$result = $db->query('SELECT p.id AS pid, p.poster

#
#---------[ 63. REPLACE WITH ]---------------------------------------------------
#

			$result = $db->query('SELECT p.id AS pid, t.topic_icon, p.poster

#
#---------[ 64. FIND ]---------------------------------------------------
#

			$result = $db->query('SELECT t.id AS tid, t.poster,

#
#---------[ 65. REPLACE WITH ]---------------------------------------------------
#

			$result = $db->query('SELECT t.id AS tid, t.topic_icon, t.poster,

#
#---------[ 66. FIND ]---------------------------------------------------
#

				if ($cur_search['poster_id'] > 1)
				{
					if ($pun_user['g_view_users'] == '1')
						$pposter = '<strong><a href="profile.php?id='.$cur_search['poster_id'].'">'.$pposter.'</a></strong>';
					else
						$pposter = '<strong>'.$pposter.'</strong>';
				}

#
#---------[ 67. AFTER, ADD ]---------------------------------------------------
#


    $icon = array();

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
    if ( $cur_search['pid'] == $cur_search['first_post_id'] )
    {
    	$icon[$cur_search['tid']] = ( ( isset( $cur_search['topic_icon'] ) AND ( $cur_search['topic_icon'] == '0' ) ) OR !array_key_exists( $cur_search['topic_icon'], $topic_icons ) ) ? '' : '<img src="'.get_base_url(true).'/plugins/topic-icon/icons/'.$topic_icons[$cur_search['topic_icon']]['filename'].'" alt="" /> ';
    }
    else
    	$icon[$cur_search['tid']] = '';

#
#---------[ 68. FIND ]---------------------------------------------------
#

<h2><span><span class="conr">#<?php echo ($start_from + $post_count) ?></span> <span><?php if ($cur_search['pid'] != $cur_search['first_post_id']) echo $lang_topic['Re'].' ' ?><?php echo $forum ?></span> <span>»&#160;<a href="viewtopic.php?id=<?php echo $cur_search['tid'] ?>"><?php echo pun_htmlspecialchars($cur_search['subject']) ?></a></span> <span>»&#160;<a href="viewtopic.php?pid=<?php echo $cur_search['pid'].'#p'.$cur_search['pid'] ?>"><?php echo format_time($cur_search['pposted']) ?></a></span></span></h2>

#
#---------[ 69. REPLACE WITH ]---------------------------------------------------
#

<h2><span><span class="conr">#<?php echo ($start_from + $post_count) ?></span> <span><?php if ($cur_search['pid'] != $cur_search['first_post_id']) echo $lang_topic['Re'].' ' ?><?php echo $forum ?></span> <span>»&#160;<a href="viewtopic.php?id=<?php echo $cur_search['tid'] ?>"><?php echo pun_htmlspecialchars($cur_search['subject']) ?></a></span> <span>»&#160;<?php echo $icon[$cur_search['tid']] ?><a href="viewtopic.php?pid=<?php echo $cur_search['pid'].'#p'.$cur_search['pid'] ?>"><?php echo format_time($cur_search['pposted']) ?></a></span></span></h2>

#
#---------[ 70. FIND ]---------------------------------------------------
#

				// Insert the status text before the subject

#
#---------[ 71. BEFORE, ADD ]---------------------------------------------------
#


    $icon = array();

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
      $icon[$cur_search['tid']] = ( ( isset( $cur_search['topic_icon'] ) AND ( $cur_search['topic_icon'] == '0' ) ) OR !array_key_exists( $cur_search['topic_icon'], $topic_icons ) ) ? '' : '<img src="'.get_base_url(true).'/plugins/topic-icon/icons/'.$topic_icons[$cur_search['topic_icon']]['filename'].'" alt="" /> ';

      if ( isset( $icon[$cur_search['tid']] ) AND $icon[$cur_search['tid']] != '' )
        $subject = implode(' ', $icon).' '.$subject;

#
#---------[ 72. OPEN ]---------------------------------------------------
#

viewforum.php

#
#---------[ 73. FIND ]---------------------------------------------------
#

		$sql = 'SELECT id, poster, subject,

#
#---------[ 74. REPLACE WITH ]---------------------------------------------------
#

		$sql = 'SELECT id, poster, topic_icon, subject,

#
#---------[ 75. FIND ]---------------------------------------------------
#

		$sql = 'SELECT p.poster_id AS has_posted, t.id, t.subject,

#
#---------[ 76. REPLACE WITH ]---------------------------------------------------
#

		$sql = 'SELECT p.poster_id AS has_posted, t.id, t.topic_icon, t.subject,

#
#---------[ 77. FIND ]---------------------------------------------------
#

		// Insert the status text before the subject

#
#---------[ 78. BEFORE, ADD ]---------------------------------------------------
#


    $icon = array();

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
      $icon[$cur_topic['id']] = ( ( isset( $cur_topic['topic_icon'] ) AND ( $cur_topic['topic_icon'] == '0' ) ) OR !array_key_exists( $cur_topic['topic_icon'], $topic_icons ) ) ? '' : '<img src="'.get_base_url(true).'/plugins/topic-icon/icons/'.$topic_icons[$cur_topic['topic_icon']]['filename'].'" alt="" /> ';

      if ( isset( $icon[$cur_topic['id']] ) AND $icon[$cur_topic['id']] != '' )
        $subject = implode(' ', $icon).' '.$subject;

#
#---------[ 79. OPEN ]---------------------------------------------------
#

viewtopic.php

#
#---------[ 80. FIND ]---------------------------------------------------
#

	$result = $db->query('SELECT t.subject,

#
#---------[ 81. REPLACE WITH ]---------------------------------------------------
#

	$result = $db->query('SELECT t.topic_icon, t.subject,

#
#---------[ 82. FIND ]---------------------------------------------------
#

	$result = $db->query('SELECT t.subject,

#
#---------[ 83. REPLACE WITH ]---------------------------------------------------
#

	$result = $db->query('SELECT t.topic_icon, t.subject,

#
#---------[ 84. FIND ]---------------------------------------------------
#

require PUN_ROOT.'header.php';

#
#---------[ 85. AFTER, ADD ]---------------------------------------------------
#

//  Load cached topic_icon
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

#
#---------[ 86. FIND ]---------------------------------------------------
#

<li><span>»&#160;</span><strong><a href="viewtopic.php?id=<?php echo $id ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></strong></li>

#
#---------[ 87. REPLACE WITH ]---------------------------------------------------
#

<?php $icon = ( isset( $cur_topic['topic_icon'] ) AND $cur_topic['topic_icon'] == '0'  OR !array_key_exists( $cur_topic['topic_icon'], $topic_icons ) ) ? '' : '<img src="'.get_base_url(true).'/plugins/topic-icon/icons/'.$topic_icons[$cur_topic['topic_icon']]['filename'].'" alt="" /> '; ?>
      <li><span>»&#160;</span><strong><?php echo $icon ?><a href="viewtopic.php?id=<?php echo $id ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></strong></li>

#
#---------[ 88. FIND ]---------------------------------------------------
#

<li><span>»&#160;</span><strong><a href="viewtopic.php?id=<?php echo $id ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></strong></li>

#
#---------[ 89. REPLACE WITH ]---------------------------------------------------
#

<?php $icon = ( isset( $cur_topic['topic_icon'] ) AND $cur_topic['topic_icon'] == '0'  OR !array_key_exists( $cur_topic['topic_icon'], $topic_icons ) ) ? '' : '<img src="'.get_base_url(true).'/plugins/topic-icon/icons/'.$topic_icons[$cur_topic['topic_icon']]['filename'].'" alt="" /> '; ?>
      <li><span>»&#160;</span><strong><?php echo $icon ?><a href="viewtopic.php?id=<?php echo $id ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></strong></li>

