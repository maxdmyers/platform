@layout('manuals::templates/cover')

@section('cover')
<div class="front">

	<a class="brand" href="{{ URL::to('manuals') }}">
		<img src="{{ Theme::asset('manuals::img/brand.png') }}" alt="Platform by Cartalyst">
	</a>

	<p class="lead">
		We make sure every extension created for Platform is well documented and easily improved by our community.
	</p>

	<ul class="nav nav-tabs nav-stacked">
		@foreach ($manuals as $folder => $name)
			<li class="{{ $folder === $active_manual ? 'active' : null }}">
				{{ HTML::link('manuals/'.$folder, $name) }}
			</li>
		@endforeach
	</ul>
</div>
@endsection



