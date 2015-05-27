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

<p><strong>Note:</strong> All scores have been emailed to those who requested them. If you have not recieved an email and were expecting one, let me (Xepher) know. Email xepherATxepherDOTnet</p>
<p>This site will remain online until the end of August. It may be taken down after that, so please read/save any stories you wish to view before then.</p>

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

