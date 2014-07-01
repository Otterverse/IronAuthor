@section("header")
  <div class="header">
    <div class="container">
      <h1>Iron Author
	@if (Auth::check())
	&mdash; {{ Auth::user()->username }}
	@endif
	</h1><br>
	@if (Auth::check())

    @if (Auth::user()->contestant)
     {{link_to('/story/edit/0', "Edit Story") }}
     {{link_to('/story/view/0', "View Story") }}
    @endif


    @if (Auth::user()->judge || Auth::user()->admin)
      {{link_to('/story/list', "Stories") }}
    @endif

    @if (Auth::user()->reviewer || Auth::user()->admin)
      {{link_to('/reviews', "Reviews") }}
    @endif

    @if (Auth::user()->admin)
     {{link_to('/admin/user', "Users") }}
    @endif

	  {{link_to('/logout', "Logout") }}



	@else
	 {{link_to('/login', "Login") }}
	 {{link_to('/register', "Create Account") }}
	@endif


    </div>
  </div>
@show
