<?php
namespace Afrittella\BackProject\Contracts;

/***
 * Interface BaseRepository
 * Freely inspired by https://github.com/bosnadev/repository
 * @package Afrittella\BackProject\Contracts
 *
 */

interface BaseRepository
{
    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

    public function findAllBy($field, $value, $columns = array('*'));

    public function findWhere($where, $columns = array('*'), $or = false);
}
