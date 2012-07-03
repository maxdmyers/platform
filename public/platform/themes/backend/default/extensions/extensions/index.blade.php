@layout('templates.template')

@section('title')
	{{ Lang::line('extensions::extensions.general.title') }}
@endsection

@section('links')

@endsection

@section('body_scripts')

@endsection

@section('content')
<section id="extensions">

	<header class="head row">
		<div class="span6">
			<h1>{{ Lang::line('extensions::extensions.title') }}</h1>
			<p>{{ Lang::line('extensions::extensions.tagline') }}</p>
		</div>
	</header>

	<hr>

    <div id="table">
    	<div class="row">
			<div class="span12">
				<div class="table-wrapper">
					<table id="installed-extension-table" class="table table-bordered">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Slug</th>
								<th>Author</th>
								<th>Description</th>
								<th>Version</th>
								<th>Is Core</th>
								<th>Status</th>
								<th></th>
							</tr>
						<thead>
						<tbody>
							@include('extensions::partials.table_extensions')
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<div id="table">
    	<div class="row">
			<div class="span12">
				<div class="table-wrapper">
			    	<table id="uninstalled-extension-table" class="table table-bordered">
						<thead>
							<tr>
								<th>{{ Lang::line('extensions::extensions.table.name') }}</th>
								<th>{{ Lang::line('extensions::extensions.table.slug') }}</th>
								<th>{{ Lang::line('extensions::extensions.table.author') }}</th>
								<th>{{ Lang::line('extensions::extensions.table.description') }}</th>
								<th>{{ Lang::line('extensions::extensions.table.version') }}</th>
								<th>{{ Lang::line('extensions::extensions.table.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($uninstalled as $extension)
								<tr>
									<td>
										{{ array_get($extension, 'info.name') }}
									</td>
									<td>
										{{ array_get($extension, 'info.slug') }}
									</td>
									<td>
										{{ array_get($extension, 'info.author') }}
									</td>
									<td>
										{{ array_get($extension, 'info.description') }}
									</td>
									<td>
										{{ array_get($extension, 'info.version') }}
									</td>
									<td>
										<a class="btn" href="{{ URL::to_secure(ADMIN.'/extensions/install/'.array_get($extension, 'info.slug')) }}" onclick="return confirm('Are you sure you want to install the \'{{ e(array_get($extension, 'info.name')) }}\' extension?');">install</a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="6">
										Good news! All extensions have been installed!
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>

</section>

@endsection
