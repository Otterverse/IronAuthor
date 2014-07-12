@extends("layout")
@section("content")
<p class="errors"><b>{{ Session::get('message'); }}</b></p>

@if(Auth::user() && Auth::user()->contestant)
  <button onclick="window.location.href='/story/edit/0';">Edit Story</button><br>
@endif
@if(Auth::user() && Auth::user()->admin)
  <button onclick="window.location.href='/story/edit/{{ $story->id }}';">Edit Story</button><br>
@endif
  <h1>{{ $story->title }}</h1>
@if(Contest::find(1)->publiclist)
<h3>by {{ $story->user->username }}</h3>
@endif

@if (Auth::user() && (Auth::user()->judge || Auth::user()->admin))
  @foreach ($story->reviews()->get() as $review)
    <table class="review_view">
      <thead>
      <tr><th colspan=3>Review by {{ $review->user->username }}
      @if($review->user->id == Auth::user()->id || Auth::user()->admin)
      {{ link_to('/review/edit/' . $review->id, '(edit)') }}
      {{ link_to('/review/delete/' . $review->id, '(delete)') }}
      @endif
      </th></tr>
      <tbody>
      @foreach(array('technical', 'structure', 'impact', 'theme', 'misc') as $type)
        <tr><td class="review_label">{{ ucfirst($type). ":" }}</td>
        <td {{ ($review->pending) ? 'class="pending_score"' : '' }}>{{ $review->{$type.'_score'} }}</td>
        @if($type == 'technical')
          <td class="text_column review_label">Notes:</td>
        @endif
        @if($type == 'structure')
            <td class="notes_view" rowspan=4 class="text_column {{ ($review->pending) ? 'pending_score' : '' }}">
            {{ BBCode::parse($review->notes) }}
            </td>
          @endif
          </tr>
      @endforeach
      </tbody>
    </table>
    <br>
  @endforeach
@endif
<div class='story_body_view'>{{ BBCode::parse($story->body) }}</div>
@stop
