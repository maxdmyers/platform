@layout('templates.template')

@section('title')
	{{ Lang::line('users::users.title') }}
@endsection

@section('links')
	{{ Theme::asset('users::css/users.less') }}
	{{ Theme::asset('css/table.css') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/table.js', 'users::js/users.js') }}
@endsection

@section('content')
	<section id="users">
		<header class="container-fluid">
			<div class="row-fluid">

				<h1 class="span4">{{ Lang::line('users::users.title') }}</h1>

				<div class="span8">
					<ul class="nav nav-pills pull-right">
						<li>
							<a class="btn" href="{{ url(ADMIN.'/users/create') }}">{{ Lang::line('users::users.btn_new_user') }}</a>
						</li>
					</ul>
				</div>
			</div>

			<hr>

			<div id="table-actions">

				<div id="table-filters" class="form-inline"></div>

				<div id="table-filters-applied"></div>

			</div>

		</header>


		<div id="table-wrapper">
				<table id="users-table" class="table table-bordered">
					<thead>
						<tr>
							@foreach ($columns as $key => $col)
								<th data-table-key="{{ $key }}">{{ $col }}</th>
							@endforeach
							<th></th>
						</tr>
					<thead>
					<tbody>
						@include('users::partials.table_users')
					</tbody>
				</table>
				<div class="tabs-right">
					<ul id="table-pagination" class="nav nav-tabs"></ul>
				</div>
			</div>
		</div>

	</section>

@endsection
