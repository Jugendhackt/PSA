<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta lang="de">
    <title>{{env('APP_NAME')}}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
    {{ HTML::style('css/style.css') }}
    {{ HTML::style('css/game.css')}}
  </head>
  <body>
    <!--<div class="round">25</div>-->
    <div class="heading"><h1>Tweet-Game</h1></div>
    <div class="tweetText">Hier könnte ihre Werbung stehen!</div>
    <button class="button">Überprüfen</button>
    {{ HTML::script('js/game.js') }}
  </body>
</html>
