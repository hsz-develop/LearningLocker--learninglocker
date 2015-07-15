<?php namespace Lockr\Export;
use Lockr\StoreResource\MongoModel as BaseClass;

class MongoModel extends BaseClass implements Model {
  protected $collection = 'exports';
  protected $fillable = ['name', 'description', 'lrs', 'fields', 'report'];
}
