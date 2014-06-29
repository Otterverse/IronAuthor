<!DOCTYPE html>
<html lang="en">
  <head>
  @section('head')
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="/css/layout.css" />
    <title>Iron Author</title>
  @show
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
