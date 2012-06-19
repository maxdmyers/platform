<div class="modal fade edit-help" id="edit-help">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>
			Markdown Cheat Sheet
			<small>Scroll down for more</small>
		</h3>
	</div>
	<div class="modal-body">









		<h4>
			Typography
			<small>
				Formatting your text
			</small>
		</h4>
		<div class="row-fluid help-section">
			<div class="span6">
				<pre class="markup">#Heading 1
##Heading 2
###Heading 3
####Heading 4

Normal text is typed normally.

Two line breaks will format paragraphs.

>This is a block quote. Use this to summarize your points</pre>
				<span class="label label-info">We use <kbd>atx-style</kbd> headings with no trailing <kbd>#</kbd></span>
			</div>
			<div class="span6 result"></div>
		</div>









		<hr>









		<h4>
			Lists
			<small>
				Displaying details
			</small>
		</h4>
		<div class="row-fluid help-section">
			<div class="span6">
				<pre class="markup">1. Foo
2. Bar
1. Baz

- Foo
- Bar
- Baz

Foo
: Bar
: Baz</pre>
			</div>
			<div class="span6 result"></div>
		</div>









		<hr>









		<h4>
			Links &amp; Images
			<small>Help explain your thoughts</small>
		</h4>
		<div class="row-fluid help-section">
			<div class="span6">
				<pre class="markup">Click [here](http://example.com "Link title") for more.

![Platform]({{ Theme::asset('manuals::img/help/platform.png') }} "Image title")</pre>
				<span class="label label-info">The <kbd>"Title"</kbd> parameter is optional</span>
			</div>
			<div class="span6 result"></div>
		</div>









		<hr>









		<h4>
			Code
			<small>Examples are everything</small>
		</h4>
		<div class="row-fluid help-section">
			<div class="span6">
				<pre class="markup">Code can like `$foo = $bar->baz();` can be shown using backticks.

Code blocks are used by indenting code with a tab

	/**
	 * Create new object instance
	 */
	$foo = new Bar();
	$bat = $foo->bar('baz');
	unset($foo); // Save memory
</pre>
				<span class="label label-info">We prefer a <kbd>tab</kbd> for code indentation rather than spaces</span>
			</div>
			<div class="span6 result"></div>
		</div>









		<hr>









		<h4>
			Tables
			<small>Great for displaying data</small>
		</h4>
		<div class="row-fluid help-section">
			<div class="span6">
				<pre class="markup">Tables are made using a set of dashes and pipes:

Name            | Age | Gender
:-------------- | :-  | :-----
John Appleseed  | 25  | Male
Greg Doe        | 41  | Male
Alexis Robinson | 18  | Female
</pre>
				<span class="label label-info">The <kbd>:</kbd> specify the alignment of the table cells</span>
				<br>
				<span class="label">You cannot currently nest markdown tables</span>
			</div>
			<div class="span6 result"></div>
		</div>









		<hr>









		<h4>
			Misc
		</h4>
		<div class="row-fluid help-section">
			<div class="span6">
				<pre class="markup">Add a horizontal rule to the page:

----------

Cool, right? Notice the empty line before and after the rule.
</pre>
			</div>
			<div class="span6 result"></div>
		</div>









	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
	</div>
</div>