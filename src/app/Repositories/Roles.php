<?php
namespace Afrittella\BackProject\Repositories;

class Roles extends Base
{
    public function model()
    {
        return config('laravel-permission.models.role');
    }

    public function create(array $data)
    {
        $role = $this->model->create($data);

        if (!empty($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }

        return $role;
    }

    public function update(array $data, $id, $attribute = 'id')
    {
        $model_data = $this->findBy($attribute, $id);
        if (!empty($data['permissions'])) {
            $model_data->permissions()->sync($data['permissions']);
        }
        return $model_data->update($data);
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
                trans('back-project::roles.name'),
                trans('back-project::roles.permissions'),
                trans('back-project::crud.actions'),
            ]
        ];

        $body = [];

        foreach ($data as $row):
            $actions = [];

            if ($row->name !== 'administrator' and $row->name !== 'user') {
                $actions = [
                    'edit' => ['url' => route('roles.edit', [$row['id']])], //url('/admin/users/edit', [$row['id']])],
                    'delete' => ['url' => route('roles.delete', [$row['id']])]
                ];
            }

            $body[] = [
                'columns' => [
                    ['content' => $row->name],
                    ['content' => implode('<br>', $row->permissions->pluck('name')->toArray())],
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