@extends("layout")
@section("content")
<p class="errors"><b>{{ Session::get('message'); }}</b></p>
  {{ Form::open() }}
  {{ Form::label("username", "Username") }}<br>
  {{ Form::text("username") }}<br>
  {{ Form::label("password", "Password") }}<br>
  {{ Form::password("password") }}<br>
  {{ Form::submit("Login") }}
  {{ Form::close() }}
  <a href='/register'>Create Account</a>
@stop
