<?php
namespace Afrittella\BackProject\Repositories;

use Afrittella\BackProject\Contracts\BaseRepository;

class Permissions extends Base
{
    public function model()
    {
        return config('laravel-permission.models.permission');
    }

    public function create(array $data)
    {
        $role = $this->model->create($data);

        if (!empty($data['roles'])) {
            $role->roles()->sync($data['roles']);
        }

        return $role;
    }

    public function update(array $data, $id, $attribute = 'id')
    {
        $model_data = $this->findBy($attribute, $id);
        if (!empty($data['roles'])) {
            $model_data->roles()->sync($data['roles']);
        }
        return $model_data->update($data);
    }

    public function firstOrCreate($data)
    {
        // If permissions are in format permission1,permission2...
        if (!is_array($data)) {
            $perms = explode(',', $data);
        } else {
            $perms = $data;
        }

        foreach ($perms as $perm):
            $this->model->firstOrCreate([
                'name' => trim(strtolower($perm))
            ]);
        endforeach;
    }

    /**
     * Transform data in a table array for view
     * @param $data
     * @param array $options
     * @return array
     */
    public function transform($data = [], $options = [])
    {
        if (empty($data)) {
            $data = $this->all();
        }

        // Table header
        $head = [
            'columns' => [
                trans('back-project::permissions.name'),
                trans('back-project::permissions.roles'),
                trans('back-project::crud.actions'),
            ]
        ];

        $body = [];

        foreach ($data as $row):
            $actions =[];

            if ($row->name !== 'administration' and $row->name !== 'backend') {
                $actions = [
                    'edit' => ['url' => route('permissions.edit', [$row['id']])],
                    'delete' => ['url' => route('permissions.delete', [$row['id']])]
                ];
            }

            $body[] = [
                'columns' => [
                    ['content' => $row->name],
                    ['content' => implode('<br>', $row->roles->pluck('name')->toArray())],
                    ['content' => false, 'actions' => $actions],
                ]
            ];
        endforeach;

        return [
            'head' => $head,
            'body' => $body
        ];
    }

}