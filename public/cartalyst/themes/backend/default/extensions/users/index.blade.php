@layout('templates/template')

@section('title')
	{{ __('users::users.title') }}
@endsection

@section('links')
	{{ Theme::asset('css/table.css') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/table.js', 'users::js/users.js') }}
@endsection

@section('content')
	<section id="users" class="row-fluid">
		<h1>{{ __('users::users.title') }}</h1>
		<div id="table-actions">
			<div class="row-fluid">
				<div id="table-filters" class="span8"></div>
				<div id="actions" class="span4">
					<a class="btn-large btn-primary" href="{{ url(ADMIN.'/users/create') }}">{{ __('users::users.btn_new_user') }}</a>
				</div>
			</div>
			<div class="row-fluid">
				<div id="table-filters-applied" class="span12"></div>
			</div>
		</div>

		<div id="table-wrapper">
			<div class="row-fluid">
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
