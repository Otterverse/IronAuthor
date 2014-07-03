@extends("layout")
@section("content")


<h1>{{ $review->story()->first()->title }}</h1>

@foreach($errors->all() as $message)
	<p class="errors"><b>{{ $message }}</b></p>
@endforeach

{{ Form::open() }}
<table class="review_edit">
  <thead>
  <tr><th colspan=3>Review by {{ $review->user->username }}</th></tr>
  <tbody>
  <td class="text_column" colspan=3>Your review comments MAY BE SHARED WITH THE AUTHOR.  BE POLITE, and be brief.
    Reviews are anonymous by default – if you want to ID yourself, sign your review.
    </td>
  @foreach(array('technical', 'structure', 'impact', 'theme', 'misc') as $type)
    <tr><td>
    {{ Form::label($type.'_score', ucfirst($type). ":") }}
    </td><td>
    {{ Form::select($type.'_score',array(
                     '' => '?',
                     0 => 0,
                     1 => 1,
                     2 => 2,
                     3 => 3,
                     4 => 4,
                     5 => 5,
                   ), (Input::old($type.'_score')) ? Input::old($type.'_score') : $review->{$type.'_score'}) }}
    </td>
      @if($type == 'technical')
        <td class="text_column">{{ Form::label("notes", "Notes: ") }} BBCode is allowed!
        <button type="button" onclick="window.open('/bbcode.html', 'newwindow', 'height=600, width=400');">BBCode Help</button>
    </td>
      @endif
      @if($type == 'structure')
        <td rowspan=5 class="text_column">
        {{ Form::textarea("notes", (Input::old('notes')) ? Input::old('notes') : $review->notes, array('class' => 'review_notes')) }}
        </td>
      @endif

      </tr>
  @endforeach
    <tr><td colspan=2>
    {{ Form::hidden('review_id', $review->id) }}
    {{ Form::submit("Save and View") }}
    {{ Form::reset("Reset") }}
    <button onclick="window.location.href='/review/delete/{{ $review->id }}';">Delete!</button>
    </td></tr>
  </tbody>
</table>
{{ Form::close() }}

<p class='story_body_view'>{{ BBCode::parse($review->story()->first()->body) }}</p>

@stop

