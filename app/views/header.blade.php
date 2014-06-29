@section("header")
  <div class="header">
    <div class="container">
      <h1>Iron Author
	@if (Auth::check())
	&mdash; {{ Auth::user()->username }}
	@endif
	</h1><br>
	@if (Auth::check())
	 {{link_to('/story/edit', "Edit Story") }}
	 {{link_to('/story/view', "View Story") }}
	 {{link_to('/logout', "Logout") }}
	@else
	 {{link_to('/login', "Login") }}
	 {{link_to('/register', "Create Account") }}
	@endif
    </div>
  </div>
@show
