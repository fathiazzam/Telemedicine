<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!DOCTYPE html>
<html>
  <head>
    <title>vchat - a simple video chat app</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/style.css">
    <script src="https://ok1static.oktacdn.com/assets/js/sdk/okta-signin-widget/2.6.0/js/okta-sign-in.min.js" type="text/javascript"></script>
    <link href="https://ok1static.oktacdn.com/assets/js/sdk/okta-signin-widget/2.6.0/css/okta-sign-in.min.css" type="text/css" rel="stylesheet"/>
    <link href="https://ok1static.oktacdn.com/assets/js/sdk/okta-signin-widget/2.6.0/css/okta-theme.css" type="text/css" rel="stylesheet"/>
    <script src="https://webrtc.github.io/adapter/adapter-4.2.2.js"></script>
    <script src="./assets/js/auth.js"></script>
    <script src="./assets/js/video.js"></script>
  </head>
  <body>
    <div class="container">
      <header>
        <h1><a href="/">vchat</a></h1>
        <h2><a href="/">a simple video chat app</a></h2>
      </header>

      <div id="okta-login-container"></div>

      <div class="row">
        <div class="col"></div>
        <div class="col-md-auto align-self-center">
          <p id="login"><b>NOTE</b>: You are not currently logged in. If you'd like to start your own
            chat room please <button type="button" class="btn btn-light" onclick="document.location='/'">log in</button></p>
          <div id="url" class="alert alert-dark" role="alert">
            <span id="roomIntro">ROOM URL</span>: <span id="roomUrl"></span>
          </div>
        </div>
        <div class="col"></div>
      </div>

      <div id="remotes" class="row">
        <div class="col-md-6">
          <div class="videoContainer">
            <video id="selfVideo" oncontextmenu="return false;"></video>
            <meter id="localVolume" class="volume" min="-45" max="-20" high="-25" low="-40"></meter>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <p>Hacked together by <a href="https://twitter.com/rdegges">@rdegges</a>
        and <a href="https://twitter.com/oktadev">@oktadev</a>.</p>
    </footer>

    <script>
      handleLogin();
    </script>
  </body>
</html>
