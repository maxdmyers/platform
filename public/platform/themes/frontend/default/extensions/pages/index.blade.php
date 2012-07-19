@layout('templates.default')

<!-- Page Title -->
@section('title')
	@get.settings.general.title
@endsection

<!-- Page Content -->
@section('content')
<section id="home">
	<div class="features row-fluid">
		<div class="span4">
			<h2>Developer Centric</h3>
			<p>
				Platform is core light and built on Laravel, a strong PHP framework with great documentation. The primary purpose of our core is to allow the creation of completely modular extensions. They act as independent entities and can be extended or accessed via an internal API and that we believe is rocks!
		</div>

		<div class="span4">
			<h2>Designer Friendly</h3>
			<p>
				A powerful theme system that gives front end developers a solid separation between logic and markup. We created a wonderful cascading architecture for our theme exsten. Then we created a simple override system with fallback support allowing you unlimited themes and templates for your front end, and back end.
			</p>
		</div>

		<div class="span4">
			<h2>Open Source</h3>
			<p>
				Platform is open source with a strong focus on exemplary documentation, community support, and framework. We have a strong “open web” philosophy and comittment to bringing developers and end users together. to help sustain and improve the Platform system.
			</p>
		</div>
	</div>
	<hr>
	<div class="points row-fluid">
		<div class="span4">
			<h3>Modular Extensions</h3>
			<p>
				Every extension in Platform is completely modular and found in one place.
			</p>
		</div>
		<div class="span4">
			<h3>Awesome API</h3>
			<p>
				Create, read, update and delete from any extension with a powerful internal API.
			</p>
		</div>
		<div class="span4">
			<h3>Widgets &amp; Plugins</h3>
			<p>
				Create simple or complex widgets and call them from anywhere within your views.
			</p>
		</div>
	</div>
	<div class="points row-fluid">
		<div class="span4">
			<h3>Authentication and Authorization</h3>
			<p>
				 A complete, feature rich auth system with a simple yet powerful permission system.
			</p>
		</div>
		<div class="span4">
			<h3>Dashboard Ready</h3>
			<p>
				A powerful and default admin UI with all the bells and whistles using Twitter bootstrap.
			</p>
		</div>
		<div class="span4">
			<h3>Boodstrap Ready</h3>
			<p>
				We chose bootstrap for both our front and backend themes. But use whatever you want.
			</p>
		</div>
	</div>
</section>
@endsection
