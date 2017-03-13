<?php
namespace Afrittella\BackProject\Repositories;

use Afrittella\BackProject\Contracts\BaseRepository;

class Attachments extends Base
{
    public function model()
    {
        return 'Afrittella\BackProject\Models\Attachment';
    }

    public function update(array $data, $id, $attribute="id")
    {
        $model_data = $this->model->where($attribute, '=', $id)->first();

        if (!$model_data) {
            throw new NotFoundException();
        }

        if (!empty($data['is_main'])) {
            $this->model->where('user_id', '=', $model_data->user_id)->where('id', '<>', $id)->update(['is_main' => 0]);
        }

        if (!$model_data->update($data)) {
            throw new NotSavedException();
        }

        return true;
    }
}
