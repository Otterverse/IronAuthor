@extends("layout")
@section("head")
  @parent
  <script src="/js/sorttable.js"></script>
@stop

@section("onload")
@parent
      sorttable.innerSortFunction.apply(document.getElementById('default_sort'), []);
@stop
@section("script")
@parent
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

@stop

@section("content")
<p class="errors"><b>{{ Session::get('message'); }}</b></p>

<h3>Phase: {{$phase ? $phase : 'Combined Total'}}</h3>
<button>{{ link_to('/story/list/Preliminary', 'Preliminary') }}</button>
<button>{{ link_to('/story/list/Final', 'Final') }}</button>
<button>{{ link_to('/story/list/Public', 'Public') }}</button>
<button>{{ link_to('/story/list', 'Combined Total') }}</button>
<button onclick="showHideAuth();"><a href=#>Show/Hide Authors</a></button>

{{Form::open()}}

<table class="sortable">
<thead>
  <tr>
    <th id='default_sort'>ID</th>
    <th class="author_cell">Author</th>
    <th>Story Title/Notes</th>
    <th>Phase</th>
    <th>Total</th>
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
  <td class="master_cell">{{ $story->id }}</td>
  <td class="master_cell author_cell">{{ $story->user()->first()->username }}</td>
  <td class="master_cell text_column">{{ link_to('/story/view/' . $story->id, $story->title) }}</td>
  <td class="master_cell">{{ Form::select('phase_'.$story->id, array('Preliminary', 'Final'), $story->phase)}}</td>
  <td class="master_cell {{ score($story->total_score, 5) }}">{{ $story->total_score }}</td>
  <td class="master_cell {{ score($story->technical_score) }}">{{ $story->technical_score }}</td>
  <td class="master_cell {{ score($story->structure_score) }}">{{ $story->structure_score }}</td>
  <td class="master_cell {{ score($story->impact_score) }}">{{ $story->impact_score }}</td>
  <td class="master_cell {{ score($story->theme_score) }}">{{ $story->theme_score }}</td>
  <td class="master_cell {{ score($story->misc_score) }}">{{ $story->misc_score }}</td>
  </tr>
  @foreach ($story->reviews($phase)->get() as $review)
    <?php
      $total = $review->technical_score + $review->structure_score
      + $review->impact_score + $review->theme_score
      + $review->misc_score;
      $total = ($total) ? $total : '';
    ?>
    <tr class="detail_row detail_row_{{ $story->id }}">
    <td>&nbsp;</td>
    <td class="author_cell">{{ $review->user->username }}</td>
    <td colspan=2 class="text_column notes_view"><div class="notes_cell" onclick="showHideNotes(this)">{{ BBCode::parse($review->notes) }}</div></td>
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

{{ Form::submit('Save Phases', array('class' => 'noclear')) }}
{{ Form::reset('Reset', array('class' => 'noclear')) }}
{{ Form::close() }}

@stop

<?php
  function score($score, $multi = 1) {
    if($score == '') { return 'pending_score';}
    if($score <= 1 * $multi ) { return 'low_score';}
    if(1 * $multi < $score && $score < 4 * $multi) { return 'medium_score';}
    if($score >= 4 * $multi ) { return 'high_score';}
  }
?>
