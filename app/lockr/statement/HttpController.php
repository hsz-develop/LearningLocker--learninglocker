<?php namespace Lockr\Statement;
use Auth as IlluminateAuth;
use Response as IlluminateResponse;
use LockerRequest as LockerRequest;
use Lockr\Client\Repository as ClientRepository;
use Lockr\StoreResource\HttpController as BaseClass;

class HttpController extends BaseClass {
  protected $repo;

  public function __construct(Repository $repo, ClientRepository $client_repo) {
    $this->repo = $repo;
    $this->client_repo = $client_repo;
  }

  protected function constructJsonResponse($data = null, $code = 200) {
    return IlluminateResponse::json($data, $code);
  }

  /**
   * Gets the data from the request.
   * @return Mixed
   */
  protected function getData() {
    return json_decode(LockerRequest::getContent(), true);
  }

  /**
   * Gets the options from the request.
   */
  protected function getOptions() {
    $user = IlluminateAuth::user();
    $client = $this->client_repo->showFromAuth(LockerRequest::header('Authorization'));

    if ($user === null && $client === null) throw new \Exception('Unauthorized.');

    return [
      'client' => $client,
      'user' => $user
    ];
  }

  private function getParam($param) {
    $param_value = LockerRequest::getParam($param);
    $value = json_decode($param_value, true);
    if ($value === null && $param_value === null) {
      throw new \Exception("Expected `$param` to be defined as a URL parameter.");
    } else if ($value === null) {
      throw new \Exception("Expected the value of `$param` to be valid JSON in the URL parameter.");
    }
    return $value;
  }

  public function aggregate() {
    return $this->constructJsonResponse($this->repo->aggregate($this->getParam('pipeline'), $this->getOptions()));
  }

  public function insert() {
    return $this->constructJsonResponse($this->repo->insert($this->getParam('pipeline'), $this->getOptions()));
  }

  public function void() {
    return $this->constructJsonResponse($this->repo->void($this->getParam('match'), $this->getOptions()));
  }

}
