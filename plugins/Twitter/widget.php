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
	echo '<p>', $tweet->text, '</p>';
} ?>
<div>
	<a href="https://twitter.com/<?php echo $account ?>" class="twitter-follow-button" data-show-count="false">Follow @<?php echo $account ?></a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>