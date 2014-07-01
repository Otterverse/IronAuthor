@extends("layout")
  @section("head")
  @parent
  <script src="/css/sorttable.js"></script>
  <script>
   function showHideNotes(elem) {
     if (getComputedStyle(elem).getPropertyValue("max-height") != 'none')
     {
       elem.style.maxHeight = 'none';
     }else{
       elem.style.maxHeight = '4em';
     }
   }
  </script>
  @stop
@section("content")

@if (Auth::user()->reviewer)
<button onclick="window.location.href='/review/new';">Review New/Next Story</button>
 <br>
@endif
<table class="sortable">
<thead>
<tr>
<th>Story Title</th>
<th id='total_header'>Total</th>
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
  <td class="text_column">{{ link_to('/review/view/' . $review->id, $review->story->title) }}</td>
  <td {{ isPending($review); }}>{{ $total }}</td>
  <td {{ isPending($review); }}>{{ $review->technical_score }}</td>
  <td {{ isPending($review); }}>{{ $review->structure_score }}</td>
  <td {{ isPending($review); }}>{{ $review->impact_score }}</td>
  <td {{ isPending($review); }}>{{ $review->theme_score }}</td>
  <td {{ isPending($review); }}>{{ $review->misc_score }}</td>
  <td class="text_column"><div class="notes_cell" onclick="showHideNotes(this)">{{ BBCode::parse($review->notes) }}</div></td>
  </tr>

@endforeach
</tbody>
</table>

@stop

<?php
  function isPending($review)
  {
    return ($review->pending) ? 'class="pending_score"' : '';
  }
?>
