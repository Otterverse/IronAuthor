@section("header")
  <div class="header">
    <div class="container">
      <h1>Iron Author
	@if (Auth::check())
	&mdash; {{ Auth::user()->username }}
	@endif
  </h1>
  <span id="countdown-holder"></span><br>
	@if (Auth::check())

	  {{link_to('/', "Welcome") }}

    @if (Auth::user()->contestant)
     {{link_to('/story/edit/0', "Edit Story") }}
     {{link_to('/story/view/0', "View Story") }}
    @endif


    @if (Auth::user()->judge || Auth::user()->admin)
      {{link_to('/story/list', "Stories") }}
    @endif

    @if (Auth::user()->reviewer || Auth::user()->admin)
      {{link_to('/reviews', "My Reviews") }}
    @endif

    @if (Auth::user()->admin)
     {{link_to('/admin/user', "Users") }}
     {{link_to('/admin/contest', "Contest") }}
    @endif

	  {{link_to('/user/settings', "Profile") }}
	  {{link_to('/logout', "Logout") }}



	@else
	 {{link_to('/login', "Login") }}
	 {{link_to('/register', "Create Account") }}
	@endif


    </div>
  </div>
@show
