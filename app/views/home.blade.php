@extends("layout")
@section("content")
<h3>Welcome {{ Auth::user()->username }}</h3>

  @if (Auth::user()->contestant)
    <button onclick="window.location.href='/story/view/0';">View/Create Story Entry</button><br>
  @endif

  @if (Auth::user()->reviewer)
    <button onclick="window.location.href='/reviews';">View/Edit Reviews</button><br>
  @endif

  @if (Auth::user()->judge)
    <button onclick="window.location.href='/story/list';">View Stories/Scores</button><br>
  @endif

<button onclick="window.location.href='/logout';">Logout</button>

@stop
