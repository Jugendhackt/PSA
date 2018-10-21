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

        $statuses = $connection->get("statuses/user_timeline", ["count" => $amount, "exclude_replies" => true, "screen_name" => $userhandle, "tweet_mode"=>"extended"]);
        if(isset($statuses->errors)){
          die("OMG OMG OMG! An error has occured! Maybe the user you have specified does not exist oooooooooooooorrrrr there has been some kind of other error. Try again. #CyberCyberCyberCyberCyber");
        }

        return $statuses;
    }


    //Die Count-Funktion, die Hashtags und ihre Anzahl, Mentions und ihre Anzahl sowie die Uhrzeiten zu denen getwittert wurde, zurückliefert.
    public static function countHashtags($userhandle, $all = false)
    {
      $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'),env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'),env('TWITTER_ACCESS_TOKEN_SECRET'));
      $content = $connection->get("account/verify_credentials");
      //$statuses = $connection->get("statuses/user_timeline", ["count"=>200, "exclude_replies" => false, "screen_name" => $userhandle, "include_rts" => false]);
      $statuses = self::getAllTweets($userhandle);

      $hashtagcounter = array();
      $user_mentioncounter = array();
      $hourcounter = array();

      for ($i = 0; $i <= 23; $i++) {
        $hourcounter[$i] = 0;
      }

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

          /*if(array_key_exists($hour,$hourcounter)) {
            $hourcounter[$hour]++;
          }else{
            $hourcounter[$hour] = 1;
          }*/

          $hourcounter[$hour]++;


        //Ist der aktuelle Hashtag schon in Hashtagcounter?
        //Ja: Value++
        //Nein: Einfügen, Value = 1
      }

      //Hashtags und mentions sortieren und nur die ersten 200 ausgeben
      if($all == false){
        uasort($hashtagcounter, function($a, $b) {
            return $b - $a;
        });
        uasort($user_mentioncounter, function($a, $b) {
            return $b- $a;
        });
        $hashtags = array_slice($hashtagcounter,0,env("MAX_HASHTAGS"));
        $mentions = array_slice($user_mentioncounter,0,env("MAX_MENTIONS"));
        $debug = array('total_tweets'=>count($statuses), 'oldest'=>$statuses[count($statuses) - 1]->created_at, 'newest'=>$statuses[0]->created_at, 'restricted_mode'=>true);
      }else{
        $hashtags = $hashtagcounter;
        $mentions = $user_mentioncounter;

        $debug = array('total_tweets'=>count($statuses), 'oldest'=>$statuses[count($statuses) - 1]->created_at, 'newest'=>$statuses[0]->created_at, 'restricted_mode'=>false);
      }


      return array('hashtags'=>$hashtags, 'mentions'=>$mentions, 'hours'=>$hourcounter, 'debug'=>$debug);
    }

    public static function randomTweet($userhandle)
    {
        $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'),env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'),env('TWITTER_ACCESS_TOKEN_SECRET'));
        $content = $connection->get("account/verify_credentials");
        $statuses = $connection->get("statuses/user_timeline", ["count"=>200, "exclude_replies" => true, "screen_name" => $userhandle, "include_rts" => false, "tweet_mode"=>"extended"]);

        //Wenn mehr als ein Hashtag UND wenn Hashtag nicht so sehr am Ende Ist
        //Wenn die Endposition des letzten Hashtags weniger als 30 Zeichen vom Ende entfernt ist (da ist ja auch noch die t.co url), dann ist der Hashtag am Ende des Tweets
        //Letzter Hashtag Endposition: $hashtags[count($hashtags)-1]->indices[1] - strlen($tweet) < 35


        $status_array = array();
        $i = 0;
        foreach($statuses as $status) {
            $status_array[$i] = $status;
            $i++;
        }

        $rightTweetFound = True;
        $counter = 0;

        while($rightTweetFound and $counter<sizeof($status_array)+20){
            $randtw = rand(0,sizeof($status_array)-1);
            $tweet = $status_array[$randtw]; //get random tweet
            //count hashtags
            $hashtags = [];
            foreach($tweet->entities->hashtags as $hashtag){
                array_push($hashtags,$hashtag);
            }


            if(count($hashtags) >= 1 && strlen($tweet->full_text) - $hashtags[count($hashtags)-1]->indices[1] > 35) { //something
            //if(count($hashtags) >= 1) { //something

                $order   = array("\r\n", "\n", "\r");
                $replace = ' <br/> ';// Processes \r\n's first so they aren't converted twice.
                $newstr = str_replace($order, $replace, $tweet->full_text);

                $raword = explode(" ",$newstr);
                $zzahl = rand(0,count($raword)-1);
                $schalter = 0;
                while ($schalter == 0) {
                    if (substr(0,1) == "#") {
                      $schalter = 0;
                    } else {
                      $schalter = 1;
                    }
                  $zword = $raword[$zzahl];
                }
                $words = explode(" ",$newstr);
                $cnt = 0;

                for ($i = 0; $i <= count($words)-1;$i++) {
                  if (substr($words[$i],0,1) == "\\n") {
                    $hashpos[$cnt] = $i;
                    $words[$i] = substr($words[$i], -(strlen($words[$i])-1));
                    $cnt++;
                  }
                }

                $hashpos = array();
                $cnt = 0;

                for ($i = 0; $i <= count($words)-1;$i++) {
                  if (substr($words[$i],0,1) == "#") {
                    $hashpos[$cnt] = $i;
                    $words[$i] = substr($words[$i], -(strlen($words[$i])-1));
                    $cnt++;
                  }
                }

                $cnt = 0;

                for ($i = 0; $i <= count($words)-1;$i++) {
                  if (substr($words[$i],0,1) == "@") {
                    //$hashpos[$cnt] = $i;
                    $words[$i] = substr($words[$i], -(strlen($words[$i])-1));
                    $cnt++;
                  }
                }


                $rausplit = explode("#",$tweet->full_text);
                $nohashtweet = "";
                if (count($rausplit) != 0) {
                  for ($i = 0; $i <= count($rausplit)-1; $i++) {
                    $nohashtweet .= $rausplit[$i];
                  }
                } else {
                  $nohashtweet = $rausplit[0];
                }

                $rausplit = explode("@",$nohashtweet);
                $queet = "";
                if (count($rausplit) != 0) {
                  for ($i = 0; $i <= count($rausplit)-1; $i++) {
                    $queet .= $rausplit[$i];
                  }
                } else {
                  $queet = $rausplit[0];
                }

                $rightTweetFound = False;
            }
            $counter++;
        }

        if($rightTweetFound) {
            return Response(array('error'=>'true'),428);
        } else {
            return array('words' => $words,'hashtag_pos'=>$hashpos,'random'=>$queet);
        }
    }

    //Gibt alle (ALLE) Tweets eines users zurück
    public static function getAllTweets($userhandle){
      $alltweets = [];

      $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'),env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'),env('TWITTER_ACCESS_TOKEN_SECRET'));
      $content = $connection->get("account/verify_credentials");
      $statuses = $connection->get("statuses/user_timeline", ["count" => 200, "exclude_replies" => true, "screen_name" => $userhandle, "tweet_mode"=>"extended"]);

      $last_id =  $statuses[count($statuses) - 1]->id;
      $alltweets = $statuses;

      $counter = 0;
      while($counter < 15 && count($statuses) > 1){
        $counter++;
        $statuses = $connection->get("statuses/user_timeline", ["count" => 200, "exclude_replies" => false, "include_rts" => false, "max_id"=>$last_id,"exclude_replies" => true, "screen_name" => $userhandle]);
        $alltweets = array_merge($alltweets, $statuses);
      }



      return $alltweets;


  }
}
