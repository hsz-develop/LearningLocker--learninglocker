<?php namespace Lockr\Client;
use Lockr\StoreResource\EloquentRepository as BaseClass;

class EloquentRepository extends BaseClass implements Repository {
  public function __construct(Model $model) {
    parent::__construct($model);
  }

  /**
   * Constructs a query restricted by the given options.
   * @param [String => Mixed] $opts
   * @return \Jenssegers\Mongodb\Eloquent\Builder
   */
  protected function where(array $opts) {
    return $this->model->where('lrs_id', $opts['client']->lrs_id);
  }

  private function showFromCreds($username, $password) {
    $model = $this->model->where('api.basic_key', $username)->where('api.basic_secret', $password)->first();
    return $model;
  }

  private function showFromBAuth($auth) {
    $auth = substr($auth, strlen('Basic '));
    list($username, $password) = explode(':', base64_decode($auth));
    return $this->showFromCreds($username, $password);
  }

  private function showFromOAuth($auth) {
    $token = substr($auth, strlen('Bearer '));
    $db = \App::make('db')->getMongoDB();

    $username = $db->oauth_access_tokens->find([
      'access_token' => $token
    ])->getNext()['client_id'];
    $password = $db->oauth_clients->find([
      'client_id' => $username
    ])->getNext()['client_secret'];

    return $this->showFromCreds($username, $password);
  }

  public function showFromAuth($auth) {
    if ($auth !== null && strpos($auth, 'Basic') === 0) {
      return $this->showFromBAuth($auth);
    } else if ($auth !== null && strpos($auth, 'Bearer') === 0) {
      return $this->showFromOAuth($auth);
    } else {
      throw new \Exception('Invalid auth');
    }
  }
}
