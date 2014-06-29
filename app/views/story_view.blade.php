@extends("layout")
@section("content")
<p class="errors"><b>{{ Session::get('message'); }}</b></p>
<h1>{{ $story->title }}</h1>
<p class='story_body_view'>{{ BBCode::parse($story->body) }}</p>
@stop
