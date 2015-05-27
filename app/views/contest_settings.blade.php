@extends("layout")
@section("content")

@foreach($errors->all() as $message)
	<p class="errors"><b>{{ $message }}</b></p>
@endforeach

{{ Form::open() }}
<table class="review_edit">
<tbody>
  <thead>
  <tr><th colspan=2>Contest Rules and Settings</th></tr>
 
 <tr>
  <td class="text_column" colspan=2>{{ Form::label("secret_rules", "Secret Rules: ") }}<br>
    Shown on welcome page only once contest is live. BBCode is allowed.<br>
    <button type="button" onclick="window.open('/bbcode.html', 'newwindow', 'height=600, width=400');">BBCode Help</button>
  </td>
  </tr><tr>
  <td class="text_column" colspan=2>
    {{ Form::textarea("secret_rules", $contest->secret_rules, array('class' => 'review_notes')) }}
  </td>
 </tr>

 <tr>
  <td class="text_column" colspan=2>{{ Form::label("general_rules", "General Rules: ") }}<br>
      Always shown on welcome page. BBCode is allowed.<br>
    <button type="button" onclick="window.open('/bbcode.html', 'newwindow', 'height=600, width=400');">BBCode Help</button>
  </td>
  </tr><tr>
  <td class="text_column" colspan=2>
    {{ Form::textarea("general_rules", $contest->general_rules, array('class' => 'review_notes')) }}
  </td>
 </tr>
 

 <tr>
  <td class="text_column">{{ Form::label("max_reviews", "Max Reviews: ") }}<br>
    Desired number of reviews per story.</td>
  <td class="text_column" colspan=2>
    {{ Form::text("max_reviews", $contest->max_reviews) }}
  </td>
 </tr>

 <tr>
  <td class="text_column" colspan=2>
    {{ Form::label('locked', 'Lock Contest') }}
    {{ Form::checkbox('locked', 1, $contest->locked) }}
  </td>
 </tr>
 
 <tr>
  <td class="text_column" colspan=2>
    {{ Form::label('publiclist', 'Make Entries Public') }}
    {{ Form::checkbox('publiclist', 1, $contest->publiclist) }}
  </td>
 </tr>

 <tr>
  <td class="text_column"><strong>Current Time: </strong><br>
    Time on the server, as of page load.</td>
  <td class="text_column" colspan=2>
    {{ date('Y-m-d H:i:s', time()) }}
  </td>
 </tr>
 <tr>
  <td class="text_column">{{ Form::label("start_time", "Start Time: ") }}<br>
    Strtotime() format. Any proper date/time string allowed. Leave blank for "now."</td>
  <td class="text_column" colspan=2>
    {{ Form::text("start_time", date('Y-m-d H:i:s', $contest->start_time)) }}
  </td>
 </tr>
<tr>
  <td class="text_column">{{ Form::label("stop_time", "Stop Time: ") }}<br>
    Strtotime() format. Any proper date/time string allowed.</td>
  <td class="text_column" colspan=2>
    {{ Form::text("stop_time", date('Y-m-d H:i:s', $contest->stop_time)) }}
  </td>
 </tr>
<tr>
  <td class="text_column">{{ Form::label("duration", "Duration (Minutes): ") }}<br>
    Use <strong>INSTEAD</strong> of stop time.</td>
  <td class="text_column" colspan=2>
    {{ Form::text("duration") }}
  </td>
 </tr>
<tr>
  <td class="text_column">{{ Form::label("grace_time", "Grace Time (Minutes): ") }}<br>
    Number of minutes to still allow story saves after Stop Time.</td>
  <td class="text_column" colspan=2>
    {{ Form::text("grace_time", $contest->grace_time) }}
  </td>
 </tr>


 <tr>
  <td colspan=2>
    {{ Form::submit("Save") }}
    {{ Form::reset("Reset") }}
   </td>
 </tr>
</tbody>
</table>
{{ Form::close() }}

@stop

