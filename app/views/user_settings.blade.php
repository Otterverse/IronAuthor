@extends("layout")
@section("content")

@foreach($errors->all() as $message)
	<p class="errors"><b>{{ $message }}</b></p>
@endforeach

{{ Form::open() }}

    {{ Form::label('email', 'Email address') }}<br>
    {{ Form::email('email', $user->email) }}<br>

    {{ Form::label('discord', 'Discord Username') }}<br>
    {{ Form::text('discord', $user->discord, array("size" => "50")) }}<br>

    {{ Form::label('fimfic', 'User Page (FimFic or other URL) (Optional)') }}<br>
    {{ Form::text('fimfic', $user->fimfic, array("size" => "50")) }}<br>

    {{ Form::label('want_feedback', 'Want to have your score/reviews emailed to you?') }}<br>
    {{ Form::checkbox('want_feedback', 1, $user->want_feedback) }}<br>

    {{ Form::label('password', 'Password') }}<br>
    {{ Form::password('password') }}<br>

    {{ Form::label('password_confirmation', 'Password confirmation') }}<br>
    {{ Form::password('password_confirmation') }}<br>

    {{ Form::submit('Update Settings') }}

{{ Form::close() }}

@stop
