<?php
namespace Afrittella\BackProject\Repositories;

use Afrittella\BackProject\Contracts\BaseRepository;
use Afrittella\BackProject\Contracts\CriteriaInterface;
use Afrittella\BackProject\Exceptions\NotFoundException;
use Afrittella\BackProject\Exceptions\NotSavedException;
use Afrittella\BackProject\Exceptions\RepositoryException;
use Afrittella\BackProject\Repositories\Criteria\Criteria;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Base implements BaseRepository, CriteriaInterface
{
    private $app;

    protected $model;

    protected $criteria;

    protected $skipCriteria = false;

    public function __construct(Collection $collection)
    {
        //$this->app = $app;
        $this->criteria = $collection;
        $this->resetScope();
        $this->makeModel();
    }

    abstract public function model();

    public function all($columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id, $attribute="id")
    {
        $model_data = $this->model->where($attribute, '=', $id)->first();

        if (!$model_data) {
            throw new NotFoundException();
        }

        if (!$model_data->update($data)) {
            throw new NotSavedException();
        }

        return true;
    }

    public function delete($id, $attribute = 'id')
    {
        $model_data = $this->model->where($attribute, '=', $id)->first();

        if (!$model_data) {
            throw new NotFoundException();
        }

        if (!$model_data->destroy($id)) {
            throw new NotDeletexception();
        }

        return true;
    }

    public function find($id, $columns = array('*'))
    {
        $this->applyCriteria();

        $model_data = $this->model->find($id, $columns);

        if (!$model_data) {
            throw new NotFoundException();
        }

        return $model_data;
    }

    public function firstOrCreate($data)
    {
        return $this->model->findOrCreate($data);
    }

    public function findBy($attribute, $value, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function makeModel()
    {
        //$model = $this->app->make($this->model());
        $model = app()->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function resetScope() {
        $this->skipCriteria(false);
        return $this;
    }

    public function skipCriteria($status = true){
        $this->skipCriteria = $status;
        return $this;
    }

    public function getCriteria() {
        return $this->criteria;
    }

    public function getByCriteria(Criteria $criteria) {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }

    public function pushCriteria(Criteria $criteria) {
        $this->criteria->push($criteria);
        return $this;
    }

    public function  applyCriteria() {
        if($this->skipCriteria === true)
            return $this;

        foreach($this->getCriteria() as $criteria) {
            if($criteria instanceof Criteria)
                $this->model = $criteria->apply($this->model, $this);
        }

        return $this;
    }
}
