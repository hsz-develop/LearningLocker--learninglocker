<?php namespace Lockr\Resource;
use Illuminate\Routing\Controller as BaseClass;
use LockerRequest as LockerRequest;
use Response as IlluminateResponse;
use Auth as IlluminateAuth;
use Route as IlluminateRoute;

abstract class HttpController extends BaseClass {
  protected $repo;

  public function __construct(Repository $repo) {
    $this->repo = $repo;
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

    return [
      'user' => $user
    ];
  }

  /**
   * Gets all models.
   * @return [Model]
   */
  public function index() {
    return $this->constructJsonResponse($this->repo->index($this->getOptions()));
  }

  /**
   * Creates a model.
   * @return Model.
   */
  public function store() {
    return $this->constructJsonResponse($this->repo->store($this->getData(), $this->getOptions()));
  }

  /**
   * Gets a model.
   * @param String $id
   * @return Model
   */
  public function show($id) {
    return $this->constructJsonResponse($this->repo->show($id, $this->getOptions()));
  }

  /**
   * Updates an model.
   * @param String $id
   * @return Model
   */
  public function update($id) {
    return $this->constructJsonResponse($this->repo->update($id, $this->getData(), $this->getOptions()));
  }

  /**
   * Deletes an model.
   * @param String $id
   * @return Boolean
   */
  public function destroy($id) {
    return $this->constructJsonResponse($this->repo->destroy($id, $this->getOptions()), 204);
  }
}
