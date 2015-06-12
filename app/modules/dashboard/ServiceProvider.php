<?php 

namespace App\Modules\Dashboard;
 
class ServiceProvider extends \App\Modules\ServiceProvider {
 
    public function register()
    {
        parent::register('dashboard');
    }
 
    public function boot()
    {
        parent::boot('dashboard');
    }
 
}