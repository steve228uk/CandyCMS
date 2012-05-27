<?php
/**
 * @plugin Twitter Widget
 * @author Cocoon Design
 * @description Adds a Twitter account feed to the dashboard
 * @copyright 2012 (C) Cocoon Design  
 */


$account = Twitter::twitterAccount();
$tweets = simplexml_load_file("https://api.twitter.com/1/statuses/user_timeline.xml?include_entities=true&include_rts=true&screen_name=$account&count=1");

foreach ($tweets as $tweet) {

	$tweettext = $tweet->text;
	$tweettext = preg_replace('/(http:\/\/[a-z0-9\.\/]+)/i', '<a href="$1" target="_blank">$1</a>', $tweettext);
	$tweettext = preg_replace('/( @|^@)(\w+)/', '$1<a rel="nofollow" href="http://www.twitter.com/$2" target="_blank" title="Follow $2 on Twitter">$2</a>', $tweettext); 
	$tweettext = preg_replace('/( #|^#)(\w+)/', '$1<a rel="nofollow" href="https://twitter.com/#!/search?q=%23$2" target="_blank" title="$2">$2</a>', $tweettext); 
	
	echo '<p>', $tweettext, '</p>';
} ?>
<div>
	<a href="https://twitter.com/<?php echo $account ?>" class="twitter-follow-button" data-show-count="false">Follow @<?php echo $account ?></a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>