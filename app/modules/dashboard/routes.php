<?php

Route::group(array('before' => 'auth.admin'), function()
{
	Route::controller('admin/dashboard', 'App\Modules\Dashboard\Controllers\Admin\DashboardController');
});
