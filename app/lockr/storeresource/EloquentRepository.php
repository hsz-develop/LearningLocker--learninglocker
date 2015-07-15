<?php namespace Lockr\StoreResource;
use Lockr\Resource\EloquentRepository as BaseClass;

abstract class EloquentRepository extends BaseClass implements Repository {
  /**
   * Constructs a query restricted by the given options.
   * @param [String => Mixed] $opts
   * @return \Jenssegers\Mongodb\Eloquent\Builder
   */
  protected function where(array $opts) {
    return parent::where($opts)->where('lrs', $opts['client']->lrs_id);
  }
}
