<?php namespace Lockr\Export;
use Illuminate\Support\ServiceProvider as BaseClass;

class ServiceProvider extends BaseClass {

  public function register(){
    $this->app->bind(
      'Lockr\Export\Repository',
      'Lockr\Export\EloquentRepository'
    );
    $this->app->bind(
      'Lockr\Export\Model',
      'Lockr\Export\MongoModel'
    );
  }

}
