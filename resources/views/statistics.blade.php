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

    <div class="wrapper">
      <h1>Hashtags</h1>
      <h1>Mentions</h1>
    </div>

    <a href="game" class="playButton"></a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.7.0/d3.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.5/d3.layout.cloud.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
    {{ HTML::script('js/statistics.js') }}
</body>
</html>
