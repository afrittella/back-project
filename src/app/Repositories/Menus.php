<?php
namespace Afrittella\BackProject\Repositories;

use Afrittella\BackProject\Contracts\BaseRepository;

class Menus extends Base
{
    function model()
    {
        return 'Afrittella\BackProject\Models\Menu';
    }

    public function all($columns = ['*'])
    {
        return $this->model->withDepth()->defaultOrder()->whereIsRoot()->select($columns)->get();
    }

    public function children($id)
    {
        return $this->model->withDepth()->defaultOrder()->descendantsOf($id)->where('parent_id', '=', $id);
    }

    public function find($id, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->withDepth()->find($id, $columns);
    }

    public function tree($name)
    {
        $root = $this->findBy('name', $name);
        $tree = false;

        if (!empty($root)) {
            $tree = $this->model->withDepth()->defaultOrder()->descendantsOf($root->id)->toTree();
        }

        return $tree;
    }

    public function moveUp($id)
    {
        $menu = $this->model->find($id);
        return $menu->up();
    }

    public function moveDown($id)
    {
        $menu = $this->model->find($id);
        return $menu->down();
    }

    public function transform($data = [], $options = [])
    {
        if (empty($data)) {
            $data = $this->all();
        }

        // Table header
        $head = [
            'columns' => [
                trans('back-project::menus.name'),
                trans('back-project::menus.title'),
                trans('back-project::menus.route'),
                trans('back-project::menus.icon'),
                trans('back-project::crud.actions'),
            ]
        ];

        $body = [];

        foreach ($data as $row):
            $actions =[
                'edit' => ['url' => route('bp.menus.edit', [$row->id])]
            ];

            if (!$row->is_protected) {
                $actions['delete'] = ['url' => route('bp.menus.delete', [$row->id])];
            }

            $body[] = [
                'columns' => [
                    ['content' => $row->name],
                    ['content' => $row->description],
                    ['content' => $row->route],
                    ['content' => $row->icon],
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
