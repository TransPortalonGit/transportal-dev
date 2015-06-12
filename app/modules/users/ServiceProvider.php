<?php 

namespace App\Modules\Users;
 
class ServiceProvider extends \App\Modules\ServiceProvider {
 
    public function register()
    {
        parent::register('users');
    }
 
    public function boot()
    {
        parent::boot('users');
    }
 
}