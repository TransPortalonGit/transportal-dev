<?php 

namespace App\Modules\Analytics;
 
class ServiceProvider extends \App\Modules\ServiceProvider {
 
    public function register()
    {
        parent::register('analytics');
    }
 
    public function boot()
    {
        parent::boot('analytics');
    }
 
}