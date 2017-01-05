<?php

return array(

	'pdf' => array(
		'enabled' => true,
		'binary' => env('SNAPPY_PDF_BINARY'),
		'timeout' => 3600,
		'options' => array(),
		'env' => array(),
	),
	'image' => array(
		'enabled' => true,
		'binary' => env('SNAPPY_IMAGE_BINARY'),
		'timeout' => 3600,
		'options' => array(),
		'env' => array(),
	),

);
