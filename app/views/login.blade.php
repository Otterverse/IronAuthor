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
  <button type="button" onclick="window.location.href='/register';">Create Account</button>
@stop
