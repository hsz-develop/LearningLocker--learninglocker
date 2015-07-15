<?php namespace Lockr\Report;
use Lockr\StoreResource\MongoModel as BaseClass;

class MongoModel extends BaseClass implements Model {
  protected $collection = 'reports';
  protected $fillable = ['name', 'description', 'lrs', 'query', 'since', 'until'];
}
