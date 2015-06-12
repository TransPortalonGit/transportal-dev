<?php 

namespace App\Modules\Inventory;
 
class ServiceProvider extends \App\Modules\ServiceProvider {
 
    public function register()
    {
        parent::register('inventory');
    }
 
    public function boot()
    {
        parent::boot('inventory');
    }
 
}