<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;

class UserTimelineController extends Controller
{

    //Debugfunktion, die alle Inhalte der Timeline dumpt
    public static function dumpTimeline($userhandle, $amount)
    {
        $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'),env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'),env('TWITTER_ACCESS_TOKEN_SECRET'));
        $content = $connection->get("account/verify_credentials");

        $statuses = $connection->get("statuses/user_timeline", ["count" => $amount, "exclude_replies" => true, "screen_name" => $userhandle]);
        if(isset($statuses->errors)){
          die("OMG OMG OMG! An error has occured! Maybe the user you have specified does not exist oooooooooooooorrrrr there has been some kind of other error. Try again. #CyberCyberCyberCyberCyber");
        }


        header('Content-Type: application/json');
        echo json_encode($statuses);
    }

    //Die Count-Funktion, die Hashtags und ihre Anzahl, Mentions und ihre Anzahl sowie die Uhrzeiten zu denen getwittert wurde, zurückliefert.
    public static function countHashtags($userhandle)
    {
      $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'),env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'),env('TWITTER_ACCESS_TOKEN_SECRET'));
      $content = $connection->get("account/verify_credentials");
      $statuses = $connection->get("statuses/user_timeline", ["count"=>200, "exclude_replies" => false, "screen_name" => $userhandle, "include_rts" => false]);

      $hashtagcounter = array();
      $user_mentioncounter = array();
      $hourcounter = array();

      if(isset($statuses->errors)){
        die("OMG OMG OMG! An error has occured! Maybe the user you have specified does not exist oooooooooooooorrrrr there has been some kind of other error. Try again. #CyberCyberCyberCyberCyber");
      }


      foreach($statuses as $status) {
          foreach($status->entities->hashtags as $hashtag){
            if(array_key_exists($hashtag->text,$hashtagcounter)) {
                $hashtagcounter[$hashtag->text]++;
            }else{
              $hashtagcounter[$hashtag->text] = 1;
            }

            //Ist der aktuelle Hashtag schon in Hashtagcounter?
            //Ja: Value++
            //Nein: Einfügen, Value = 1
          }

          foreach($status->entities->user_mentions as $user_mention){
            if(array_key_exists($user_mention->screen_name,$user_mentioncounter)) {
                $user_mentioncounter[$user_mention->screen_name]++;
            }else{
              $user_mentioncounter[$user_mention->screen_name] = 1;
            }

            //Ist der aktuelle Hashtag schon in Hashtagcounter?
            //Ja: Value++
            //Nein: Einfügen, Value = 1
          }

          //$hour = substr($status->created_at, 8,2);
          $arhour = date_parse($status->created_at);
          $hour = $arhour["hour"];
          if(array_key_exists($hour,$hourcounter)) {
            $hourcounter[$hour]++;
          }else{
            $hourcounter[$hour] = 1;
          }


        //Ist der aktuelle Hashtag schon in Hashtagcounter?
        //Ja: Value++
        //Nein: Einfügen, Value = 1
      }
      return array('hashtags'=>$hashtagcounter, 'mentions'=>$user_mentioncounter, 'hours'=>$hourcounter);
    }

    public static function randomTweet($userhandle)
    {
        $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'),env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'),env('TWITTER_ACCESS_TOKEN_SECRET'));
        $content = $connection->get("account/verify_credentials");
        $statuses = $connection->get("statuses/user_timeline", ["count"=>200, "exclude_replies" => true, "screen_name" => $userhandle, "include_rts" => false]);

        $status_array = array();
        $i = 0;
        foreach($statuses as $status) {
            $status_array[$i] = $status;
            $i++;
        }

        $rightTweetFound = False;

        while(!$rightTweetFound){
            $tweet = $status_array[rand(0,sizeof($status_array-1))];

            if(True) {
                $rightTweetFound = True;
            }
        }

        return $tweet;
    }

    //Gibt alle (ALLE) Tweets eines users zurück
    public static function getAllTweets($userhandle){
      $alltweets = array();

      $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'),env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'),env('TWITTER_ACCESS_TOKEN_SECRET'));
      $content = $connection->get("account/verify_credentials");
      $statuses = $connection->get("statuses/user_timeline", ["count"=>2000, "exclude_replies" => true, "screen_name" => $userhandle, "include_rts" => false]);

      array_push($alltweets, $statuses);
      $last_id = $statuses[count($statuses)]->id;

      while(count($statuses)>0){
        $statuses = $connection->get("statuses/user_timeline", ["count"=>200, "since_id"=>$last_id, "exclude_replies" => true, "screen_name" => $userhandle, "include_rts" => false]);
        array_push($alltweets, $statuses);
        $last_id = $alltweets[count($alltweets)]->id;
      }

      header('Content-Type: application/json');
      echo json_encode($alltweets);

  }
}
