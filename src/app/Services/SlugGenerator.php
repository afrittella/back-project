<?php
/**
 * TODO
 */
namespace Afrittella\BackProject\Services;

class SlugGenerator
{
    public function create($value, $model)
    {
        return str_slug($value);
    }
}