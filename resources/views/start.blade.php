<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta lang="de">
  <meta name="description" content="Tweetgame">
  <title>PSA Twitter-Login</title>
  {{ HTML::style('css/style.css') }}
  {{ HTML::style('css/start.css') }}
</head>
<body>
  <div class="container">
  <img src="img/logo.png" height="100" width="100" class="logo">
    <div class="Uberschrift"><h1 class="Überschrift">Start</h1>
    </div>
    <h3> Bitte gib einen Twitter-Account ein:</h3>
      <form action="statistics" method="get">
        <input type="text" name="name" class="TextInput" placeholder="Twitter-Name" required> <br>
        <button type="submit" class="button">Senden</button>
      </form>
  </div>
</div>
</body>
</html>
