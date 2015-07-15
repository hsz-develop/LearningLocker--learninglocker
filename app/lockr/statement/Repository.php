<?php namespace Lockr\Statement;

interface Repository {
  public function aggregate(array $pipeline, array $opts);
  public function insert(array $pipeline, array $opts);
  public function void(array $match, array $opts);
}
