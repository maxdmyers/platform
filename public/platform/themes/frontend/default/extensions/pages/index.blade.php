@layout('templates.default')

@section('title')
	@get.settings.general.title
@endsection

@section('links')

@endsection

@section('body_scripts')

@endsection

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
			<span class="ico-drawer"></span>
			<h3>Modular Extensions</h3>
			<p>
				Every extension in Platform is completely modular and found in one place.
			</p>
		</div>
		<div class="span4">
			<span class="ico-cog"></span>
			<h3>Awesome API</h3>
			<p>
				Create, read, update and delete from any extension with a powerful internal API.
			</p>
		</div>
		<div class="span4">
			<span class="ico-thumbs-up"></span>
			<h3>Expressivly Awesome</h3>
			<p>
				We aim to be as expressive as possible whenever possible using simple, expressive syntax.
			</p>
		</div>
	</div>
	<div class="points row-fluid">
		<div class="span4">
			<span class="ico-key"></span>
			<h3>Authentication and Authorization</h3>
			<p>
				 A complete, feature rich auth system with a simple yet powerful permission system.
			</p>
		</div>
		<div class="span4">
			<span class="ico-equalizer"></span>
			<h3>Dashboard Ready</h3>
			<p>
				A powerful and default admin UI with all the bells and whistles using Twitter bootstrap.
			</p>
		</div>
		<div class="span4">
			<span class="ico-cube"></span>
			<h3>Widget here, widget there!</h3>
			<p>
				Create simple or complex widgets and call them from anywhere within your views.
			</p>
		</div>
	</div>
</section>

@endsection
