@layout('templates.template')

@section('title')
	{{ Lang::line('users::groups.title_edit') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/bootstrap/bootstrap-tab.js') }}
@endsection

@section('content')
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#general" data-toggle="tab">General</a></li>
		<li><a href="#permissions" data-toggle="tab">Permissions</a></li>
	</ul>
	<div class="tab-content">
	    <div class="tab-pane active" id="general">
	    	@widget('platform.users::groups.form.edit', $id)
	    </div>
	    <div class="tab-pane" id="permissions">
	    	@widget('platform.users::groups.form.permissions', $id)
	    </div>
  	</div>
</div>
@endsection
