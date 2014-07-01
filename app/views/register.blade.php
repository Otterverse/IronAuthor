@extends("layout")
@section("content")

@foreach($errors->all() as $message)
	<p class="errors"><b>{{ $message }}</b></p>
@endforeach

{{ Form::open() }}

    {{ Form::label('username', 'Username') }}<br>
    {{ Form::text('username', Input::old('username')) }}<br>

    {{ Form::label('email', 'Email address') }}<br>
    {{ Form::email('email', Input::old('email')) }}<br>

    {{ Form::label('password', 'Password') }}<br>
    {{ Form::password('password') }}<br>

    {{ Form::label('password_confirmation', 'Password confirmation') }}<br>
    {{ Form::password('password_confirmation') }}<br>

    {{ Form::submit('Register') }}

{{ Form::close() }}

@stop
