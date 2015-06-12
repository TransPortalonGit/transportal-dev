<?php

Route::group(array('before' => 'auth.admin'), function()
{
	Route::controller('admin/users', 'App\Modules\Users\Controllers\Admin\UserController');
});
