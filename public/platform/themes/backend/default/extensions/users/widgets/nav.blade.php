<ul class="nav nav-list">
	<li class="nav-header">
		Logged in as:
	</li>
  	<li>
  		<!-- TODO:: Add current user id -->
  		<a href="{{ url(ADMIN.'/users/edit/'. Cartalyst::user()->get('id')) }}">
  			<!-- TODO: update once auth is working -->
  			{{ Cartalyst::user()->get('metadata.first_name').' '.Cartalyst::user()->get('metadata.last_name') }}
  			<i class="icon-book"></i>
  		</a>
  	</li>
  	<li class="divider"></li>
	<li>
		<a href="{{ url(ADMIN.'/logout') }}">
			Sign Out
			<i class="icon-book"></i>
		</a>
	</li>
	<li class="divider"></li>
</ul>
