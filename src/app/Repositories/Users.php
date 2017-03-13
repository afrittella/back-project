<?php
namespace Afrittella\BackProject\Repositories;

use Afrittella\BackProject\Contracts\BaseRepository;
use Kalnoy\Nestedset\QueryBuilder;

class Users extends Base
{
    public function model()
    {
        return config('back-project.user_model');
    }

    public function create(array $data)
    {
      $user =  $this->model->create([
          'username' => $data['username'],
          'email' => $data['email'],
          'password' => bcrypt($data['password']),
          'confirmation_code' => $this->model->generateConfirmationCode(), //@TODO confirmation_code is dynamic
          //'role_id' => $data['role_id'],
      ]);

      if (!empty($data['roles'])) {
          $user->roles()->sync($data['roles']);
      }

      return $user;
    }

    public function update(array $data, $id, $attribute = 'id')
    {
        $model_data = $this->findBy($attribute, $id);
        if (!empty($data['roles'])) {
            $model_data->roles()->sync($data['roles']);
        }
        return $model_data->update($data);
    }

    /**
    * Transform data in a table array for view
    * @param $data
    * @param array $options
    */
    public function transform($data = [], $options = [])
    {
        if (empty($data)) {
            $data = $this->all();
        }

        // Table header
        $head = [
            'columns' => [
                "",
                trans('back-project::users.active'),
                trans('back-project::users.username'),
                trans('back-project::users.email'),
                trans('back-project::users.roles'),
                trans('back-project::crud.actions'),
            ]
        ];

        $body = [];

        foreach ($data as $row):
            $body[] = [
                'columns' => [
                    ['content' => '<img src="'.\Avatar::create(strtoupper($row->username))->toBase64().'" alt="'.$row->username.' width="40px" height="40px"> ' ],
                    ['content' => false, 'action' => false, 'icon' => ($row->isConfirmed() ? "check" : 'times')],
                    ['content' => $row->username],
                    ['content' => $row->email],
                    ['content' => implode(',', $row->roles()->pluck('name')->toArray())],
                    ['content' => false, 'actions' => [
                        'edit' => ['url' => route('users.edit', [$row['id']])], //url('/admin/users/edit', [$row['id']])],
                        'delete' => ['url' => route('users.delete', [$row['id']])]
                    ]
                    ],
                ]
            ];
        endforeach;

        return [
            'head' => $head,
            'body' => $body
        ];
    }

}