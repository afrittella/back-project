<?php

namespace Afrittella\BackProject\Repositories;

use Afrittella\BackProject\Contracts\BaseRepository;
use Afrittella\BackProject\Models\SocialAccount;
use Kalnoy\Nestedset\QueryBuilder;
use Laravel\Socialite\Contracts\User as SocialProvider;

class Users extends Base
{
    public function model()
    {
        return config('back-project.user_model');
    }

    public function create(array $data)
    {
        $_defaults = [
            'email' => null,
            'is_social' => 0,
            'confirmed' => 0
        ];

        $data = array_merge($_defaults, $data);

        $user = $this->model->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => (($data['is_social'] == 0) ? $this->model->generateConfirmationCode() : ''), //@TODO confirmation_code is dynamic
            'confirmed' => (($data['is_social'] == 0) ? $data['confirmed'] : 1),
            'is_social' => $data['is_social']
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

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if (!empty($data['roles'])) {
            $model_data->roles()->sync($data['roles']);
        }
        return $model_data->update($data);
    }

    public function createOrGetFromSocial(SocialProvider $socialProvider, $provider = "facebook")
    {
        // try to get user
        $account = SocialAccount::whereProvider($provider)->whereProviderUserId($socialProvider->getId())->first();

        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider' => $provider,
                'provider_user_id' => $socialProvider->getId(),
                'provider_user_info' => json_encode($socialProvider)
            ]);

            if (!empty($socialProvider->getEmail())) {
                $user = $this->findBy('email', $socialProvider->getEmail());
            }

            $username = snake_case($socialProvider->getName());

            while ($this->findBy('username', $username)) {
                $username = $this->getUniqueUsername($username);
            }

            if (empty($user)) {
                $user = $this->create([
                    'username' => $username,
                    'email' => $socialProvider->getEmail(),
                    'is_social' => 1,
                    'password' => 'no_password'
                ]);

                $user->assignRole('user');
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }

    public function getUniqueUsername($name)
    {
        $nrRand = rand(0,100);

        return $name.$nrRand;
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
                "",
                //trans('back-project::users.active'),
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
                    ['content' => '<img src="' . \Avatar::create(strtoupper($row->username))->toBase64() . '" alt="' . $row->username . ' width="40px" height="40px"> '],
                    //['content' => false, 'action' => false, 'icon' => ($row->isConfirmed() ? "check" : 'times')],
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