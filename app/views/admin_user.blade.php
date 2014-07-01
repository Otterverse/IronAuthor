@extends("layout")
@section("head")
  @parent
  <script src="/css/sorttable.js"></script>
  <style>input.</style>
@stop

@section("content")
<p class="errors"><b>{{ Session::get('message'); }}</b></p>


{{ Form::open() }}

<table class="sortable">
<thead>
  <th>ID</th>
  <th>User</th>
  <th>Email</th>
  <th>Admin?</th>
  <th>Judge?</th>
  <th>Reviewer?</th>
  <th>Contestant?</th>
</thead>
<tbody>
@foreach ($users as $user)
  <tr>
  <td>{{ $user->id }}</td>
  <td class="user_column">{{ $user->username }}</td>
  <td class="user_column">{{ Form::text('email_' . $user->id, $user->email, array('class' => 'table_input')) }}</td>
  <td class="check_column">{{ Form::checkbox('admin_' . $user->id, 1, $user->admin, array('class' => 'table_input')); }}</td>
  <td class="check_column">{{ Form::checkbox('judge_' . $user->id, 1, $user->judge, array('class' => 'table_input')); }}</td>
  <td class="check_column">{{ Form::checkbox('reviewer_' . $user->id, 1, $user->reviewer, array('class' => 'table_input')); }}</td>
  <td class="check_column">{{ Form::checkbox('contestant_' . $user->id, 1, $user->contestant, array('class' => 'table_input')); }}</td>
  </tr>
@endforeach
</tbody>
</table>

   {{ Form::submit('Save', array('class' => 'noclear')) }}
   {{ Form::reset('Reset', array('class' => 'noclear')) }}
   {{ Form::close() }}


@stop
