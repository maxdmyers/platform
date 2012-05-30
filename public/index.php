<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @version  3.2.0 Beta 1
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 * @link     http://laravel.com
 */

// --------------------------------------------------------------
// Tick... Tock... Tick... Tock...
// --------------------------------------------------------------
define('LARAVEL_START', microtime(true));

// --------------------------------------------------------------
// Indicate that the request is from the web.
// --------------------------------------------------------------
$web = true;

// --------------------------------------------------------------
// Set the core Laravel path constants.
// --------------------------------------------------------------
require '../platform/paths.php';

// --------------------------------------------------------------
// Unset the temporary web variable.
// --------------------------------------------------------------
unset($web);

/*
|--------------------------------------------------------------------------
| Set the Admin route
|--------------------------------------------------------------------------
|
| We set the admin route here so extensions.php files have access to
| the constant.  If we set it in routes, they do not have access to it
| since they would load before the define is set
|
*/

define('ADMIN', 'admin');

// --------------------------------------------------------------
// Launch Laravel.
// --------------------------------------------------------------
require path('sys').'laravel.php';
