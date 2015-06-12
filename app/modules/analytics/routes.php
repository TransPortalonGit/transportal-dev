<?php

Route::group(array('before' => 'auth.admin'), function()
{
	Route::controller('admin/analytics', 'App\Modules\Analytics\Controllers\Admin\AnalyticsController');
});
