##
##
##        Mod title:  Topic Icon 
##
##      Mod version:  0.2.6 
##   Works on PunBB:  1.5.4, 1.5.3 
##     Release date:  2013-MM-DD 
##           Author:  Daniel Rokven(rokven@gmail.com) 
##
##      Description:  Adds an icon to the first post of the topic 
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
##       DISCLAIMER:  Please note that 'mods' are not officially supported by
##                    PunBB. Installation of this modification is done at your
##                    own risk. Backup your forum database and any and all
##                    applicable files before proceeding.
##
##             Note:  Thanks to quy for helping me

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

// Set $icon_id
// if $_POST['topic_icon'] isset then that takes precedence over $cur_post['topic_icon']
$icon_id = isset( $_POST['icon_id'] ) ? intval( $_POST['icon_id'] ) : $cur_post['topic_icon'];

if ( $icon_id > '0' )
{
  include( PUN_ROOT.'/plugins/topic-icon/generate_topic_icon_img_markup.php' );
  $icon = generate_topic_icon_img_markup( $icon_id );
}
else
{
  $icon = '';
}

#
#---------[ 9. FIND ]---------------------------------------------------
#

$db->query('UPDATE '.$db->prefix.'topics SET subject=\''.$db->escape($subject).'\', sticky='.$stick_topic.' WHERE id='.$cur_post['tid'].' OR moved_to='.$cur_post['tid']) or error('Unable to update topic', __FILE__, __LINE__, $db->error());

#
#---------[ 10. REPLACE WITH ]---------------------------------------------------
#

$db->query('UPDATE '.$db->prefix.'topics SET topic_icon=\''.$icon_id.'\', subject=\''.$db->escape($subject).'\', sticky='.$stick_topic.' WHERE id='.$cur_post['tid'].' OR moved_to='.$cur_post['tid']) or error('Unable to update topic', __FILE__, __LINE__, $db->error());

#
#---------[ 11. FIND ]---------------------------------------------------
#

<li><span>»&#160;</span><a href="viewtopic.php?id=<?php echo $cur_post['tid'] ?>"><?php echo pun_htmlspecialchars($cur_post['subject']) ?></a></li>

#
#---------[ 12. REPLACE WITH ]---------------------------------------------------
#

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

<li><span>»&#160;</span><a href="viewtopic.php?id=<?php echo $tid ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></li>

#
#---------[ 21. REPLACE WITH ]---------------------------------------------------
#

<?php
if ( $cur_topic['topic_icon'] > '0' )
{
  include( PUN_ROOT.'/plugins/topic-icon/generate_topic_icon_img_markup.php' );
  $icon = generate_topic_icon_img_markup( $cur_topic['topic_icon'] );
}
else
{
  $icon = '';
}
      ?>
      <li><span>»&#160;</span><?php echo $icon ?><a href="viewtopic.php?id=<?php echo $tid ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></li>

#
#---------[ 22. FIND ]---------------------------------------------------
#

<li><span>»&#160;</span><a href="viewtopic.php?id=<?php echo $tid ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></li>

#
#---------[ 23. REPLACE WITH ]---------------------------------------------------
#

<li><span>»&#160;</span><?php echo $icon ?><a href="viewtopic.php?id=<?php echo $tid ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></li>

#
#---------[ 24. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT poster, subject,

#
#---------[ 25. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT poster, topic_icon, subject,

#
#---------[ 26. FIND ]---------------------------------------------------
#

$db->query('INSERT INTO '.$db->prefix.'topics (poster, subject, posted, last_post, moved_to, forum_id) VALUES(\''.$db->escape($moved_to['poster']).'\', \''.$db->escape($moved_to['subject']).'\', '.$moved_to['posted'].', '.$moved_to['last_post'].', '.$cur_topic.', '.$fid.')') or error('Unable to create redirect topic', __FILE__, __LINE__, $db->error());

#
#---------[ 27. REPLACE WITH ]---------------------------------------------------
#

$db->query('INSERT INTO '.$db->prefix.'topics (poster, topic_icon, subject, posted, last_post, moved_to, forum_id) VALUES(\''.$db->escape($moved_to['poster']).'\', \''.$db->escape($moved_to['topic_icon']).'\', \''.$db->escape($moved_to['subject']).'\', '.$moved_to['posted'].', '.$moved_to['last_post'].', '.$cur_topic.', '.$fid.')') or error('Unable to create redirect topic', __FILE__, __LINE__, $db->error());

#
#---------[ 28. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT id, poster, subject,

#
#---------[ 29. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT id, poster, topic_icon, subject,

#
#---------[ 30. FIND ]---------------------------------------------------
#

// Insert the status text before the subject

#
#---------[ 31. BEFORE, ADD ]---------------------------------------------------
#

if ( $cur_topic['topic_icon'] > '0' )
{
  include( PUN_ROOT.'/plugins/topic-icon/generate_topic_icon_img_markup.php' );
  $subject = generate_topic_icon_img_markup( $cur_topic['topic_icon'] ).$subject;
}
#
#---------[ 32. OPEN ]---------------------------------------------------
#

post.php

#
#---------[ 33. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT f.id, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.subject,

#
#---------[ 34. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT f.id, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.topic_icon, t.subject,

#
#---------[ 35. FIND ]---------------------------------------------------
#

// Did someone just hit "Submit" or "Preview"?

#
#---------[ 36. BEFORE, ADD ]---------------------------------------------------
#

// Set $icon_id
$icon_id = !empty( $_POST['icon_id'] ) ? intval( $_POST['icon_id'] ) : ( ( isset( $cur_posting['topic_icon'] ) AND !empty( $cur_posting['topic_icon'] ) ) ? $cur_posting['topic_icon'] : '' );

if ( $icon_id > '0' )
{
  include( PUN_ROOT.'/plugins/topic-icon/generate_topic_icon_img_markup.php' );
  $icon = generate_topic_icon_img_markup( $icon_id );
}
else
{
  $icon = '';
}

if ( isset( $_POST['req_subject'] ) )
{
  $rec_subject = isset( $_POST['req_subject'] ) ? pun_htmlspecialchars( $_POST['req_subject'] ) : '';
  $icon = $icon.$rec_subject;
}


#
#---------[ 37. FIND ]---------------------------------------------------
#

$db->query('INSERT INTO '.$db->prefix.'topics (poster, subject, posted, last_post, last_poster, sticky, forum_id) VALUES(\''.$db->escape($username).'\', \''.$db->escape($subject).'\', '.$now.', '.$now.', \''.$db->escape($username).'\', '.$stick_topic.', '.$fid.')') or error('Unable to create topic', __FILE__, __LINE__, $db->error());

#
#---------[ 38. REPLACE WITH ]---------------------------------------------------
#

$db->query('INSERT INTO '.$db->prefix.'topics (poster, topic_icon, subject, posted, last_post, last_poster, sticky, forum_id) VALUES(\''.$db->escape($username).'\', \''.$icon_id.'\', \''.$db->escape($subject).'\', '.$now.', '.$now.', \''.$db->escape($username).'\', '.$stick_topic.', '.$fid.')') or error('Unable to create topic', __FILE__, __LINE__, $db->error());

#
#---------[ 39. FIND ]---------------------------------------------------
#

<?php if (isset($cur_posting['subject'])): ?>     <li><span>»&#160;</span><a href="viewtopic.php?id=<?php echo $tid ?>"><?php echo pun_htmlspecialchars($cur_posting['subject']) ?></a></li>

#
#---------[ 40. REPLACE WITH ]---------------------------------------------------
#

<?php if (isset($_POST['req_subject'])): ?>     <li><span>»&#160;</span><?php echo $icon ?></li>
<?php endif; ?>
<?php if (isset($cur_posting['subject'])): ?>     <li><span>»&#160;</span><?php echo $icon ?><a href="viewtopic.php?id=<?php echo $tid ?>"><?php echo pun_htmlspecialchars($cur_posting['subject']) ?></a></li>

#
#---------[ 41. FIND ]---------------------------------------------------
#

<?php endif; ?>						<label class="required"><strong><?php echo $lang_common['Message'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />

#
#---------[ 42. REPLACE WITH ]---------------------------------------------------
#

<?php endif; 

if ($fid)
	include ( PUN_ROOT.'/plugins/topic-icon/add_topic.php' );

?>						<label class="required"><strong><?php echo $lang_common['Message'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />

#
#---------[ 43. OPEN ]---------------------------------------------------
#

search.php

#
#---------[ 44. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT p.id AS post_id, p.topic_id,

#
#---------[ 45. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT p.id AS post_id, t.topic_icon, p.topic_id,

#
#---------[ 46. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT m.post_id, p.topic_id,

#
#---------[ 47. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT m.post_id, t.topic_icon, p.topic_id,

#
#---------[ 48. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT p.id AS post_id, p.topic_id FROM

#
#---------[ 49. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT p.id AS post_id, p.topic_id, t.topic_icon FROM

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

$result = $db->query('SELECT t.id FROM

#
#---------[ 55. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT t.id, t.topic_icon FROM

#
#---------[ 56. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT p.id FROM

#
#---------[ 57. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT p.id, t.topic_icon FROM

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

$result = $db->query('SELECT t.id FROM

#
#---------[ 63. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT t.id, t.topic_icon FROM

#
#---------[ 64. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT p.id AS pid, p.poster

#
#---------[ 65. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT p.id AS pid, t.topic_icon, p.poster

#
#---------[ 66. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT t.id AS tid, t.poster,

#
#---------[ 67. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT t.id AS tid, t.topic_icon, t.poster,

#
#---------[ 68. FIND ]---------------------------------------------------
#

				if ($cur_search['poster_id'] > 1)
				{
					if ($pun_user['g_view_users'] == '1')
						$pposter = '<strong><a href="profile.php?id='.$cur_search['poster_id'].'">'.$pposter.'</a></strong>';
					else
						$pposter = '<strong>'.$pposter.'</strong>';
				}

#
#---------[ 69. AFTER, ADD ]---------------------------------------------------
#

    if ( $cur_search['pid'] == $cur_search['first_post_id'] AND $cur_search['topic_icon'] > '0' )
    {
      include( PUN_ROOT.'/plugins/topic-icon/generate_topic_icon_img_markup.php' );
      $icon = generate_topic_icon_img_markup( $cur_search['topic_icon'] );
    }
    else
    {
      $icon = '';
    }

#
#---------[ 70. FIND ]---------------------------------------------------
#

<h2><span><span class="conr">#<?php echo ($start_from + $post_count) ?></span> <span><?php if ($cur_search['pid'] != $cur_search['first_post_id']) echo $lang_topic['Re'].' ' ?><?php echo $forum ?></span> <span>»&#160;<a href="viewtopic.php?id=<?php echo $cur_search['tid'] ?>"><?php echo pun_htmlspecialchars($cur_search['subject']) ?></a></span> <span>»&#160;<a href="viewtopic.php?pid=<?php echo $cur_search['pid'].'#p'.$cur_search['pid'] ?>"><?php echo format_time($cur_search['pposted']) ?></a></span></span></h2>

#
#---------[ 71. REPLACE WITH ]---------------------------------------------------
#

<h2><span><span class="conr">#<?php echo ($start_from + $post_count) ?></span> <span><?php if ($cur_search['pid'] != $cur_search['first_post_id']) echo $lang_topic['Re'].' ' ?><?php echo $forum ?></span> <span>»&#160;<?php echo $icon ?><a href="viewtopic.php?id=<?php echo $cur_search['tid'] ?>"><?php echo pun_htmlspecialchars($cur_search['subject']) ?></a></span> <span>»&#160;<a href="viewtopic.php?pid=<?php echo $cur_search['pid'].'#p'.$cur_search['pid'] ?>"><?php echo format_time($cur_search['pposted']) ?></a></span></span></h2>

#
#---------[ 72. FIND ]---------------------------------------------------
#

// Insert the status text before the subject

#
#---------[ 73. BEFORE, ADD ]---------------------------------------------------
#

      if ( $cur_search['topic_icon'] > '0' )
      {
        include( PUN_ROOT.'/plugins/topic-icon/generate_topic_icon_img_markup.php' );
        $subject = generate_topic_icon_img_markup( $cur_search['topic_icon'] ).$subject;
      }

#
#---------[ 74. OPEN ]---------------------------------------------------
#

viewforum.php

#
#---------[ 75. FIND ]---------------------------------------------------
#

$sql = 'SELECT id, poster, subject,

#
#---------[ 76. REPLACE WITH ]---------------------------------------------------
#

$sql = 'SELECT id, poster, topic_icon, subject,

#
#---------[ 77. FIND ]---------------------------------------------------
#

$sql = 'SELECT p.poster_id AS has_posted, t.id, t.subject,

#
#---------[ 78. REPLACE WITH ]---------------------------------------------------
#

$sql = 'SELECT p.poster_id AS has_posted, t.id, t.topic_icon, t.subject,

#
#---------[ 79. FIND ]---------------------------------------------------
#

$topic_count = 0;

#
#---------[ 80. AFTER, ADD ]---------------------------------------------------
#

    include( PUN_ROOT.'/plugins/topic-icon/generate_topic_icon_img_markup.php' );

#
#---------[ 81. FIND ]---------------------------------------------------
#

// Insert the status text before the subject

#
#---------[ 82. BEFORE, ADD ]---------------------------------------------------
#

      if ( $cur_topic['topic_icon'] > '0' )
      {
        $subject = generate_topic_icon_img_markup( $cur_topic['topic_icon'] ).$subject;
      }

#
#---------[ 83. OPEN ]---------------------------------------------------
#

viewtopic.php

#
#---------[ 84. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT t.subject,

#
#---------[ 85. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT t.topic_icon, t.subject,

#
#---------[ 86. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT t.subject,

#
#---------[ 87. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT t.topic_icon, t.subject,

#
#---------[ 88. FIND ]---------------------------------------------------
#

require PUN_ROOT.'header.php';

#
#---------[ 89. AFTER, ADD ]---------------------------------------------------
#

if ( $cur_topic['topic_icon'] > '0' )
{
  include( PUN_ROOT.'/plugins/topic-icon/generate_topic_icon_img_markup.php' );
  $icon = generate_topic_icon_img_markup( $cur_topic['topic_icon'] );
}
else
{
  $icon = '';
}

#
#---------[ 90. FIND ]---------------------------------------------------
#

<li><span>»&#160;</span><strong><a href="viewtopic.php?id=<?php echo $id ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></strong></li>

#
#---------[ 91. REPLACE WITH ]---------------------------------------------------
#

<li><span>»&#160;</span><strong><?php echo $icon ?><a href="viewtopic.php?id=<?php echo $id ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></strong></li>

#
#---------[ 92. FIND ]---------------------------------------------------
#

<li><span>»&#160;</span><strong><a href="viewtopic.php?id=<?php echo $id ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></strong></li>

#
#---------[ 93. REPLACE WITH ]---------------------------------------------------
#

<li><span>»&#160;</span><strong><?php echo $icon ?><a href="viewtopic.php?id=<?php echo $id ?>"><?php echo pun_htmlspecialchars($cur_topic['subject']) ?></a></strong></li>


