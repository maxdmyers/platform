@layout('templates.template')

@section('title')
	{{ Lang::line('users::users.title') }}
@endsection

@section('links')
	{{ Theme::asset('css/table.css') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/table.js', 'users::js/groups.js') }}
@endsection

@section('content')
	<section id="users">

		<header>
			<div class="row">
				<div class="span4">
					<h1>{{ Lang::line('users::groups.title') }}</h1>
				</div>
			</div>
		</header>

		<hr>

		<div id="table">
			<div class="actions clearfix">
				<div id="table-filters" class="form-inline pull-left"></div>
				<div class="pull-right">
					<a class="btn btn-large btn-primary" href="{{ url(ADMIN.'/users/create') }}">{{ Lang::line('users::groups.btn_new_group') }}</a>
				</div>
			</div>

			<div class="row">
				<div class="span12">
					<div class="row">
						<ul id="table-filters-applied" class="nav nav-tabs span10"></ul>
					</div>
					<div class="row">
						<div class="span10">
							<div class="table-wrapper">
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

									</tbody>
								</table>
							</div>
						</div>
						<div class="tabs-right span2">
							<ul id="table-pagination" class="nav nav-tabs"></ul>
						</div>
					</div>
				</div>
			</div>

		</div>

	</section>

	</section>

@endsection
