@extends("layout")

@section("script")
document.onreadystatechange = function () {
  if (document.readyState == "interactive") {
    document.getElementsByClassName('save_button')[0].onclick = function(){
	window.btn_clicked = true;
    };
    document.getElementsByClassName('save_button')[1].onclick = function(){
	window.btn_clicked = true;
    };
  }
}

window.onbeforeunload = function(){
    if(!window.btn_clicked && formChanged('story_edit')){
        return 'Warning: You have unsaved changes that will be lost!';
    }
};

formChanged = function(className) {
    var elemArray = document.getElementsByClassName(className);
    for(var i = 0; i < elemArray.length; i++){
        var elem = document.getElementById(elemArray[i].id);
        if (elem.defaultValue != elem.value) {
            return true;
        }
    }
    return false;
}
@stop

@section("content")

@foreach($errors->all() as $message)
	<p class="errors"><b>{{ $message }}</b></p>
@endforeach

  <p><strong>Note:</strong> Please do not put your name/signature anywhere in the story or title. Entries will be judged anonymously.</p>
  <p><strong>BBCode is allowed!</strong> You can use <strong>[b]bold[/b]</strong>,
    <em>[i]italic[/i]</em>, <font color='red'>[color='red']colors[/color]</font>, etc.</p>

  {{ Form::open() }}
  {{ Form::submit("Save and View", array('class' => 'save_button')) }}
  <button type="button" onclick="window.open('/bbcode.html', 'newwindow', 'height=600, width=400');">BBCode Help</button><br>
  {{ Form::label("title", "Title") }}<br>
  {{ Form::text("title", $data['title'],  array('class' => 'story_edit', 'id' => 'edit_form')) }}<br>
  {{ Form::label("body", "Story Body") }}<br>
  {{ Form::textarea("body", $data['body'], array('class' => 'story_edit', 'rows' => '30')) }}<br>
  {{ Form::hidden('save_story', '1' ) }}
  {{ Form::submit("Save and View", array('class' => 'save_button')) }}
  <button type="button" onclick="window.open('/bbcode.html', 'newwindow', 'height=600, width=400');">BBCode Help</button><br>
  {{ Form::close() }}

@stop

