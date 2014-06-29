@extends("layout")
@section("content")
<p class="errors"><b>{{ Session::get('message'); }}</b></p>
  {{ Form::open() }}
  {{ Form::label("username", "Username") }}
  {{ Form::text("username") }}
  {{ Form::label("password", "Password") }}
  {{ Form::password("password") }}
  {{ Form::submit("Login") }}
  {{ Form::close() }}
  {{link_to('/register', "Click here to register", array('class' => 'page_link')) }}
@stop
