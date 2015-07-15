<?php namespace Lockr\Resource;

abstract class EloquentRepository implements Repository {
  protected $model;

  public function __construct(Model $model) {
    $this->model = $model;
  }

  /**
   * Constructs a query restricted by the given options.
   * @param [String => Mixed] $opts
   * @return \Jenssegers\Mongodb\Eloquent\Builder
   */
  protected function where(array $opts) {
    return $this->model;
  }

  /**
   * Gets all of the available models with the options.
   * @param [String => Mixed] $opts
   * @return [Model]
   */
  public function index(array $opts) {
    return $this->where($opts)->get();
  }

  /**
   * Gets the model with the given ID and options.
   * @param String $id ID to match.
   * @param [String => Mixed] $opts
   * @return Model
   */
  public function show($id, array $opts) {
    $model = $this->where($opts)->where('_id', $id)->first();
    if ($model === null) throw new Exceptions\NotFound($id, $this->model->getTable());
    return $model;
  }

  /**
   * Destroys the model with the given ID and options.
   * @param String $id ID to match.
   * @param [String => Mixed] $opts
   * @return Boolean
   */
  public function destroy($id, array $opts) {
    return $this->show($id, $opts)->delete();
  }

  /**
   * Creates a new model.
   * @param [String => Mixed] $data Properties of the new model.
   * @param [String => Mixed] $opts
   * @return Model
   */
  public function store(array $data, array $opts) {
    return $this->model->create($data);
  }

  /**
   * Updates an existing model.
   * @param String $id ID to match.
   * @param [String => Mixed] $data Properties to be changed on the existing model.
   * @param [String => Mixed] $opts
   * @return Model
   */
  public function update($id, array $data, array $opts) {
    $model = $this->show($id, $opts)->update($data);
    $model->save();
    return $model;
  }
}
