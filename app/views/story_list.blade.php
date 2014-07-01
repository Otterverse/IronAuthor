@extends("layout")
@section("head")
  @parent
  <script src="/css/sorttable.js"></script>
  <script type="text/javascript">
    window.onload = function () {
      window.show_auth = 0;
      sorttable.innerSortFunction.apply(document.getElementById('total_header'), []);
    };

   function showHideAuth() {
      var auth_cells = document.getElementsByClassName('author_cell');
      var toDisplay;

      if(window.show_auth > 0){
        toDisplay = 'none';
        window.show_auth = 0;
      }else{
        toDisplay = 'table-cell';
        window.show_auth = 1;
      }

      for(i=0; i<auth_cells.length; i++) {
        auth_cells[i].style.display = toDisplay;
      }
   }

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
<p class="errors"><b>{{ Session::get('message'); }}</b></p>

<button onclick="showHideAuth();">Show/Hide Authors</button>
<table class="sortable">
<thead>
  <tr>
    <th class="author_cell">Author</th>
    <th>Story Title/Notes</th>
    <th id='total_header'>Total</th>
    <th>Technical</th>
    <th>Structure</th>
    <th>Impact</th>
    <th>Theme</th>
    <th>Misc</th>
  </tr>
</thead>

<tbody>
@foreach ($stories as $story)
  <tr class="master_row master_row_{{ $story->id }}">
  <td class="master_cell author_cell">{{ $story->user()->first()->username }}</td>
  <td class="master_cell text_column">{{ link_to('/story/view/' . $story->id, $story->title) }}</td>
  <td class="master_cell {{ score($story->total_score,5) }}">{{ $story->total_score }}</td>
  <td class="master_cell {{ score($story->technical_score) }}">{{ $story->technical_score }}</td>
  <td class="master_cell {{ score($story->structure_score) }}">{{ $story->structure_score }}</td>
  <td class="master_cell {{ score($story->impact_score) }}">{{ $story->impact_score }}</td>
  <td class="master_cell {{ score($story->theme_score) }}">{{ $story->theme_score }}</td>
  <td class="master_cell {{ score($story->misc_score) }}">{{ $story->misc_score }}</td>
  </tr>
  @foreach ($story->reviews()->get() as $review)
    <?php
      $total = $review->technical_score + $review->structure_score
      + $review->impact_score + $review->theme_score
      + $review->misc_score;
      $total = ($total) ? $total : '';
    ?>
    <tr class="detail_row detail_row_{{ $story->id }}">
    <td class="author_cell">{{ $review->user->username }}</td>
    <td class="text_column notes_view"><div class="notes_cell" onclick="showHideNotes(this)">{{ BBCode::parse($review->notes) }}</div></td>
    <td class="{{ score($total,5) }}">{{ $total }}</td>
    <td class="{{ score($review->technical_score) }}">{{ $review->technical_score }}</td>
    <td class="{{ score($review->structure_score) }}">{{ $review->structure_score }}</td>
    <td class="{{ score($review->impact_score) }}">{{ $review->impact_score }}</td>
    <td class="{{ score($review->theme_score) }}">{{ $review->theme_score }}</td>
    <td class="{{ score($review->misc_score) }}">{{ $review->misc_score }}</td>
    </tr>
  @endforeach
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
