<?php namespace Lockr\Report;
use Illuminate\Support\ServiceProvider as BaseClass;

class ServiceProvider extends BaseClass {

  public function register(){
    $this->app->bind(
      'Lockr\Report\Repository',
      'Lockr\Report\EloquentRepository'
    );
    $this->app->bind(
      'Lockr\Report\Model',
      'Lockr\Report\MongoModel'
    );
  }

}
