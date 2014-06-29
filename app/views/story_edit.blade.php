@extends("layout")
@section('head')
@parent
<script type='text/javascript'>
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
</script>
@stop

@section("content")

@foreach($errors->all() as $message)
	<p class="errors"><b>{{ $message }}</b></p>
@endforeach

  {{ Form::open() }}
  {{ Form::submit("Save and View", array('class' => 'save_button')) }}
  {{ Form::label("title", "Title") }}
  {{ Form::text("title", $data['title'],  array('class' => 'story_edit', 'id' => 'edit_form')) }}
  {{ Form::label("body", "Story Body") }}
  {{ Form::textarea("body", $data['body'], array('class' => 'story_edit', 'rows' => '30')) }}
  {{ Form::hidden('save_story', '1' ) }}
  {{ Form::submit("Save and View", array('class' => 'save_button')) }}
  {{ Form::close() }}

@stop

