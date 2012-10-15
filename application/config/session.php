<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'driver'         => 'cookie',
	'storage'        => '',
	'name'           => 'kohanasession',
	'encryption'     => FALSE,
	'expiration'     => 7200,
	'regenerate'     => 3,
	'gc_probability' => 2
);