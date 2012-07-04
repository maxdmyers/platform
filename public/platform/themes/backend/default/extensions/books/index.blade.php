@layout('templates.template')

@section('title')
	{{ Lang::line('books::books.general.title') }}
@endsection

@section('links')
	{{ Theme::asset('css/table.css') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/table.js', 'books::js/books.js') }}
@endsection

@section('content')

	<header class="head row">
		<div class="span4">
			<h1>{{ Lang::line('books::books.general.title') }}</h1>
			<p>{{ Lang::line('books::books.general.description') }}</p>
		</div>
		<nav class="tertiary-navigation span8">
			@widget('platform.menus::menus.nav', 2, 1, 'nav nav-pills pull-right', ADMIN)
		</nav>
	</header>

	<hr>

	<div id="table">
		<div class="actions clearfix">
			<div id="table-filters" class="form-inline pull-left"></div>
			<div class="pull-right">
				<a class="btn btn-large btn-primary" href="{{ URL::to_secure(ADMIN.'/books/create') }}">{{ Lang::line('books::books.button.create') }}</a>
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
							<table id="books-table" class="table table-bordered">
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
						<div class="processing"></div>
						<ul id="table-pagination" class="nav nav-tabs"></ul>
					</div>
				</div>
			</div>
		</div>

	</div>

@endsection
