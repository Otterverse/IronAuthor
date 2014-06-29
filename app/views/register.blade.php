@extends("layout")
@section("content")

@foreach($errors->all() as $message)
	<p class="errors"><b>{{ $message }}</b></p>
@endforeach
    
{{ Form::open() }}

    {{ Form::label('username', 'Username') }}
    {{ Form::text('username', Input::old('username')) }}

    {{ Form::label('email', 'Email address') }}
    {{ Form::email('email', Input::old('email')) }}

    {{ Form::label('password', 'Password') }}
    {{ Form::password('password') }}

    {{ Form::label('password_confirmation', 'Password confirmation') }}
    {{ Form::password('password_confirmation') }}
    
    {{ Form::submit('Register') }}

{{ Form::close() }}

@stop
