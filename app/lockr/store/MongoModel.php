<?php namespace Lockr\Store;
use Lockr\Resource\MongoModel as BaseClass;

class MongoModel extends BaseClass implements Model {
  protected $collection = 'lrs';
  protected $fillable = ['title', 'description'];
}
