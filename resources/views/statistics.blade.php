<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta lang="de">
  <meta name="description" content="Cooler shit">
  <title>PSA Login</title>
  {{ HTML::style('css/statistics.css') }}
</head>
<body>
    <canvas id="timeStat" height="100vh"></canvas>

    <div class="wrapper left">
      <canvas type="cloud" id="wordCloudTags" width="1024" height="500"></canvas>
    </div>

    <div class="wrapper right">
      <canvas type="cloud" id="wordCloudMentions" width="1024" height="500"></canvas>
    </div>

    <a href="game" class="playButton"></a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.1.0/wordcloud2.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
    {{ HTML::script('js/statistics.js') }}
</body>
</html>
