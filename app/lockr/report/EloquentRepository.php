<?php namespace Lockr\Report;
use Lockr\StoreResource\EloquentRepository as BaseClass;

class EloquentRepository extends BaseClass implements Repository {
  public function __construct(Model $model) {
    parent::__construct($model);
  }
}
