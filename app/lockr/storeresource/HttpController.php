<?php namespace Lockr\StoreResource;
use Lockr\Client\Repository as ClientRepository;
use Lockr\Resource\HttpController as BaseClass;
use LockerRequest as LockerRequest;

abstract class HttpController extends BaseClass {
  protected $client_repo;

  public function __construct(Repository $repo, ClientRepository $client_repo) {
    parent::__construct($repo);
    $this->client_repo = $client_repo;
  }

  /**
   * Gets the options from the request.
   */
  protected function getOptions() {
    $opts = parent::getOptions();
    $client = $this->client_repo->showFromAuth(LockerRequest::header('Authorization'));

    if ($opts['user'] === null && $client === null) throw new \Exception('Unauthorized.');

    return array_merge(parent::getOptions(), [
      'client' => $client
    ]);
  }
}
