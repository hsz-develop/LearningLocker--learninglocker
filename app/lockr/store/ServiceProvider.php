<?php namespace Lockr\Store;
use Illuminate\Support\ServiceProvider as BaseClass;

class ServiceProvider extends BaseClass {

  public function register(){
    $this->app->bind(
      'Lockr\Store\Repository',
      'Lockr\Store\EloquentRepository'
    );
    $this->app->bind(
      'Lockr\Store\Model',
      'Lockr\Store\MongoModel'
    );
  }

}
