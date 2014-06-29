@extends("layout")
@section("content")
<p>Welcome {{ Auth::user()->username }}</p>
{{link_to('/logout', "Click here to logout", array('class' => 'page_link')) }}

@stop
