<!DOCTYPE html>
<html lang="en">
  <head>
  @section('head')
    <meta charset="UTF-8" />
    <title>Iron Author</title>
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="/css/jquery.countdown.css">
    <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery.plugin.js"></script>
    <script type="text/javascript" src="/js/jquery.countdown.js"></script>
  @show


  <script type="text/javascript">

@if ((Contest::find(1)->start_time && time() < Contest::find(1)->start_time) && !Contest::find(1)->locked )

  function start_timer() { $('#countdown-holder').countdown({
    until: new Date({{Contest::find(1)->start_time * 1000}}),
  serverSync: new Date({{time() * 1000}}),
    onTick: highlightLast5,
    expiryText: 'Contest Started! Click Edit Story!',
    compact: true,
    format: 'HMS', description: 'Until start'
  }); }

@else

  function start_timer() { $('#countdown-holder').countdown({
    until: new Date({{Contest::find(1)->stop_time * 1000}}),
  serverSync: new Date({{time() * 1000}}),
    onTick: highlightLast5,
    expiryText: 'Deadline expired! Contest is over!',
    compact: true,
    format: 'HMS', description: 'Remaining'
  }); }

@endif

  
  function serverTime() { 
    var time = null; 
    $.ajax({url: 'http://ironauthor.xepher.net/serverTime.php', 
        async: false, dataType: 'text', 
        success: function(text) { 
            time = new Date(text); 
        }, error: function(http, message, exc) { 
            time = new Date(); 
    }}); 
    return time; 
}

  function highlightLast5(periods) {
      if ($.countdown.periodsToSeconds(periods) < 900) {
          $(this).addClass('highlight-countdown');
      }
  }

  @section('script')

  @show

    window.onload = function () {
  @section("onload")
    start_timer();
  @show
  };

  </script>

  </head>
  <body>
    @include("header")
    <div class="content">
      <div class="container">
        @yield("content")
      </div>
    </div>
  </body>
</html>
