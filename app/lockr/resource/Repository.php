<?php namespace Lockr\Resource;

interface Repository {
  public function index(array $opts);
  public function show($id, array $opts);
  public function destroy($id, array $opts);
  public function store(array $data, array $opts);
  public function update($id, array $data, array $opts);
}
