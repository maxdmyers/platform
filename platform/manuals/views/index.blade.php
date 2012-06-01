@layout('manuals::template')

@section('brand')
<div class="brand">
	<a href="{{ URL::to('manuals') }}">
		{{ HTML::image('platform/manuals/img/brand.png', 'Platform by Cartalyst'); }}
	</a>
</div>
@endsection

@section('navigation')
<div class="navigation">
	<h1>Platform Manuals</h1>
	<p class="lead">We make sure every extension created for Platform is well documented and easily improved by our community.</p>

	<ul class="nav nav-pills">
		@foreach ($manuals as $folder => $name)
			<li class="{{ $folder === $active_manual ? 'active' : null }}">
				{{ HTML::link('manuals/'.$folder, $name) }}
			</li>
		@endforeach
	</ul>
</div>
@endsection

@section('content')

@endsection



