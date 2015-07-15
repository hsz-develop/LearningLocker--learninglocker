<?php namespace Lockr\Client;
use Lockr\StoreResource\MongoModel as BaseClass;

class MongoModel extends BaseClass implements Model {
  protected $collection = 'client';
  protected $fillable = ['name', 'description', 'lrs_id', 'query', 'since', 'until'];
}
