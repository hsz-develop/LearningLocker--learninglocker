<?php namespace Lockr\Statement;
use Illuminate\Support\ServiceProvider as BaseClass;

class ServiceProvider extends BaseClass {

  public function register(){
    $this->app->bind(
      'Lockr\Statement\Repository',
      'Lockr\Statement\EloquentRepository'
    );
  }

}
