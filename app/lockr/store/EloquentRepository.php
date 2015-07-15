<?php namespace Lockr\Store;
use Lockr\Resource\EloquentRepository as BaseClass;

class EloquentRepository extends BaseClass implements Repository {
  public function __construct(Model $model) {
    $this->model = $model;
  }
}
