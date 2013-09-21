<?php

$default_url = (isset($argv[1]))?$argv[1]:'http://ah.fm/';

$banner_current_url = 'http://www.ah.fm/stats/bannercurrent.xml';
$forum_data_url = 'http://www.ah.fm/forum/external.php?type=XML&forumids=178&count=500';
$base_url = 'http://www.ah.fm/forum/showthread.php';

$banner_data = simplexml_load_string(file_get_contents($banner_current_url));
$forum_data = simplexml_load_string(file_get_contents($forum_data_url));

$now_playing_url = '';
$next_playing_url = '';

foreach ($forum_data as $post)
{
	$now_playing = str_replace(' on AH.FM', '', $banner_data->now_playing);
	//$now_playing = str_replace('&amp;', '&', $banner_data->now_playing);
	
	$next_playing = str_replace(' on AH.FM', '', $banner_data->next_playing);
	//$next_playing = str_replace('&amp;', '&', $banner_data->next_playing);
	
	$post_title = $post->title;
	$post_title = str_replace('<![CDATA[ ', '', $post_title);
	$post_title = str_replace(' ]]>', '', $post_title);
	
	//$post_title = str_replace('&amp;', '&', $post_title);
	
	if (strtolower($post_title) == strtolower($now_playing))
	{
		$now_playing_url = "$base_url?".$post->attributes()->id;	
		$now_playing_url .= "-".str_replace(' ', '-', $now_playing);
		$now_playing_url = str_replace('---', '-', $now_playing_url);
	}

	if (strtolower($post_title) == strtolower($next_playing))
	{
		$next_playing_url = "$base_url?".$post->attributes()->id;
		$next_playing_url .= "-".str_replace(' ', '-', $next_playing);
		$next_playing_url = str_replace('---', '-', $next_playing_url);
	}
}

$now_playing_url = (!empty($now_playing_url))?$now_playing_url:$default_url;
$next_playing_url = (!empty($next_playing_url))?$next_playing_url:$default_url;

/*
SimpleXMLElement Object
(
    [now_playing] => Alex van ReeVe - Xanthe Sessions 045 on AH.FM
    [next_playing] => Ronny K. - trance4nations 062 on AH.FM
    [listeners] => 756
    [url_link] => http://ah.fm/forum/forumdisplay.php?178-Livesets
    [next_link] => empty
)
*/


//print_r($banner_data);
//print_r($forum_data);


echo "<url_link>$now_playing_url</url_link>\n";
echo "<next_link>$next_playing_url</next_link>\n";
	
?>