<?php

require "vendor/autoload.php";
require "settings.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($settings['consumer_key'], $settings['consumer_secret'], $settings['access_token'], $settings['access_token_secret']);
$content = $connection->get("statuses/user_timeline", ["screen_name" => "RichardBSpencer",
                                                        "count" => 1,
                                                        "exclude_replies" => true,
                                                        "include_rts" => false]);

$last_tweet_id = file_get_contents("last_tweet");

if($content[0]->id_str != $last_tweet_id) {
  $reply = $connection->post("statuses/update", ["status" => "@TestAccount9122",
                                                "in_reply_to_status_id" => $content[0]->id_str,
                                                "media_ids" => "828541844824825857"]);

  file_put_contents("last_tweet", $content[0]->id_str);

}
