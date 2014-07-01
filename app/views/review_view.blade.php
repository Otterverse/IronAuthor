@extends("layout")
@section("content")

  <h1>{{ $review->story()->first()->title }}</h1>
  <button onclick="window.location.href='/review/new';">Review New/Next Story</button>
  <button onclick="window.location.href='/review/edit/{{ $review->id }}';">Edit This Review</button>
  <table class="review_view">
  <thead>
  <tr><th colspan=3>Review by {{ $review->user->username }}</th></tr>
  <tbody>
  @foreach(array('technical', 'structure', 'impact', 'theme', 'misc') as $type)
    <tr><td class="review_label"> {{ ucfirst($type). ":" }} </td>
    <td {{ ($review->pending) ? 'class="pending_score"' : '' }}>{{ $review->{$type.'_score'} }}</td>
      @if($type == 'technical')
      <td class="text_column review_label">Notes:</td>
      @endif
      @if($type == 'structure')
        <td rowspan=4 class="text_column notes_view {{ ($review->pending) ? 'pending_score' : '' }}">
        {{ BBCode::parse($review->notes) }}
        </td>
      @endif
      </tr>
  @endforeach
  </tbody>
</table>

<div class='story_body_view'>{{ BBCode::parse($review->story()->first()->body) }}</div>


@stop
