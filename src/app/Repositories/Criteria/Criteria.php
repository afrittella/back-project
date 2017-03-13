<?php
namespace Afrittella\BackProject\Repositories\Criteria;

use Afrittella\BackProject\Contracts\BaseRepository;

abstract class Criteria
{
    public abstract function apply($model, BaseRepository $repository);
}