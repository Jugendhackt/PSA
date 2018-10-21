<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta lang="de">
      <meta name="description" content="Cooler shit">
      <title>PSA Login</title>
      {{ HTML::style('css/comparison.css') }}
    </head>
    <body>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.1.0/wordcloud2.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
        {{ HTML::script('js/comparison.js') }}
        <canvas id="comparisonStat" height="100vh"></canvas>
    </body>
</html>
