@extends("layout")

  @section("head")
  @parent
  <script src="/js/sorttable.js"></script>
  @stop

  @section("script")
  @parent
     function showHideNotes(elem) {
     if (getComputedStyle(elem).getPropertyValue("max-height") != 'none')
     {
       elem.style.maxHeight = 'none';
     }else{
       elem.style.maxHeight = '4em';
     }
   }
  @stop

  @section("onload")
  @parent
      sorttable.innerSortFunction.apply(document.getElementById('default_sort'), []);
  @stop

@section("content")

@if (Auth::user()->reviewer)
<button onclick="window.location.href='/review/new';">Review New/Next Story</button>
 <br>
@endif
<table class="sortable">
<thead>
<tr>
<th id='default_sort'>Story ID</th>
<th>Story Title</th>
<th>Total</th>
<th>Technical</th>
<th>Structure</th>
<th>Impact</th>
<th>Theme</th>
<th>Misc</th>
<th>Notes</th>
</tr>
</thead>

<tbody>
@foreach($reviews as $review)
    <?php
      $total = $review->technical_score + $review->structure_score
      + $review->impact_score + $review->theme_score
      + $review->misc_score;
      $total = ($total) ? $total : '';
    ?>
  <tr>
  <td>{{ $review->story_id }}</td>
  <td class="text_column">{{ link_to('/review/view/' . $review->id, $review->story->title) }}
   {{ link_to('/review/edit/' . $review->id, '(Edit)') }}</td>
  <td class="{{ score($total, 4) }}">{{ $total }}</td>
  <td class="{{ score($review->technical_score); }}">{{ $review->technical_score }}</td>
  <td class="{{ score($review->structure_score); }}">{{ $review->structure_score }}</td>
  <td class="{{ score($review->impact_score); }}">{{ $review->impact_score }}</td>
  <td class="{{ score($review->theme_score); }}">{{ $review->theme_score }}</td>
  <td class="{{ score($review->misc_score); }}">{{ $review->misc_score }}</td>
  <td class="text_column"><div class="notes_cell" onclick="showHideNotes(this)">{{ BBCode::parse($review->notes) }}</div></td>
  </tr>

@endforeach
</tbody>
</table>

@stop

<?php
  function score($score, $multi = 1) {
    if($score == '') { return 'pending_score';}
    if($score <= 1 * $multi ) { return 'low_score';}
    if(1 * $multi < $score && $score < 4 * $multi) { return 'medium_score';}
    if($score >= 4 * $multi ) { return 'high_score';}
  }
?>
