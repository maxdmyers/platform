<?php

return array(
	'ext_paths' => array(
		realpath(APPPATH.'../extensions/').DS,
	),

	/**
	 * Attribute Flags
	 * values must be base 2 format. This means multiply last value by 2 to get the next value
	 * example values: 1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048...
	 *
	 * Unique value is used to say whether this flag can be selected with other flags or not.
	 *
	 * To get flag value if using multiple flags, and their values together.
	 * Example: Backend only - Extra Data would be a flag value of 5 ( 1 + 4 )
	 */
	'attr_flags' => array(
		'backend_only' => array(
			'value'  => 1, // attribute only appears in the backend
			'unique' => false,
		),
		'stockable' => array(
			'value'  => 2, // attribute is stockable. Example: shirt color
			'unique' => true,
		),
		'extra_data' => array(
			'value'  => 4, // attribute contains extra data. Example: product weight
			'unique' => false,
		)
	)
);
