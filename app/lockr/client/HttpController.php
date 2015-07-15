<?php namespace Lockr\Client;
use Lockr\Client\Repository as ClientRepository;
use Lockr\StoreResource\HttpController as BaseClass;

class HttpController extends BaseClass {
  public function __construct(Repository $repo, ClientRepository $client_repo) {
    parent::__construct($repo, $client_repo);
  }
}
