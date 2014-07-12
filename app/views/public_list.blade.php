@extends("layout")
@section("head")
  @parent
  <script src="/js/sorttable.js"></script>
@stop

@section("onload")
@parent
      sorttable.innerSortFunction.apply(document.getElementById('default_sort'), []);
@stop


@section("content")
<p class="errors"><b>{{ Session::get('message'); }}</b></p>

<table class="sortable">
<thead>
  <tr>
    <th id="default_sort">Author</th>
    <th>Story Title</th>
  </tr>
</thead>

<tbody>
@foreach ($stories as $story)
  <tr>
  <td class="text_column">{{ $story->user()->first()->username }}</td>
  <td class="text_column">{{ link_to('/story/view/' . $story->id, $story->title) }}</td>
  </tr>
@endforeach
</tbody>
</table>
@stop

