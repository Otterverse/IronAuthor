@extends("layout")
@section("content")

<p class="errors"><b>{{ Session::get('message'); }}</b></p>

<h3>Welcome {{ Auth::user()->username }}</h3>

<?php
  $contest = Contest::find(1);
?>


<h3 class="title">Secret Rules</h3>
<div class="box">
@if (($contest->start_time && time() > $contest->start_time) && !$contest->locked )
 <p>{{ BBCode::parse($contest->secret_rules) }}</p>
@else
 <p>Additional rules/prompts will be displayed here once the contest starts.</p>
@endif
</div>

<h3 class="title">Contest Rules</h3>
<div class="box">
<strong>Scheduled Start:</strong> {{ date('Y-m-d H:i:s', $contest->start_time) }}<br>
<strong>Scheduled End:</strong> {{ date('Y-m-d H:i:s', $contest->stop_time) }}<br>
<p>{{ BBCode::parse($contest->general_rules) }}</p>
</div>


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
