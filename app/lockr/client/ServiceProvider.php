<?php namespace Lockr\Client;
use Illuminate\Support\ServiceProvider as BaseClass;

class ServiceProvider extends BaseClass {

  public function register(){
    $this->app->bind(
      'Lockr\Client\Repository',
      'Lockr\Client\EloquentRepository'
    );
    $this->app->bind(
      'Lockr\Client\Model',
      'Lockr\Client\MongoModel'
    );
  }

}
