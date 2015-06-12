<?php

Route::group(array('before' => 'auth.admin'), function()
{
	Route::controller('admin/inventory', 'App\Modules\Inventory\Controllers\Admin\InventoryController');
});
