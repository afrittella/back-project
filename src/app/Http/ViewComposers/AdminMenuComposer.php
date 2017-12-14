<?php

namespace Afrittella\BackProject\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Afrittella\BackProject\Repositories\Menus as MenuRepository;

class AdminMenuComposer
{

    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function compose(View $view)
    {
        $mainMenu = $this->menuRepository->tree('admin-menu');
        $view->with('mainMenu', $mainMenu);
        $view->with('htmlMenu', $this->menu($mainMenu));
    }

    /**
     * Format an AdminLTE Menu
     *
     * $menus must be formatted in this way:
     *
     * Menu
     *    children
     *        children
     *
     * @param array $menus
     * @return string
     *
     */
    function menu($menus)
    {
        // Retrieve current user (for permissions)
        $user = Auth::user();

        $templates = [
            "menu" => '
              <ul class="sidebar-menu">
                %s
              </ul>
        ',

            "menu_row" => '
          <li class="%s">
            %s
          </li>
        ', // class, link . submenu

            "menu_caret" => '
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>',

            "menu_subrow" => '
          <ul class="treeview-menu">
            %s
          </ul>
        ',

            "menu_link" => '
          <a href="%s"><i class="%s text-red"></i><span>%s</span>%s</a>
        ' // url, icon, title
        ];

        $traverse = function ($rows) use (&$traverse, $templates, $user) {
            $menuString = "";
            $hasActive = false;
            foreach ($rows as $menu) {
                if (!empty($menu->permission) and $user and !$user->hasPermission($menu->permission)) {
                    continue;
                }

                $hasActive = false;
                $submenu = "";
                $authorized = true;

                if ($menu->children->count() > 0) {
                    list($submenuString, $hasActive) = $traverse($menu->children);
                    $submenu = "";
                    if (!empty($submenuString)) {
                        $submenu = sprintf($templates['menu_subrow'], $submenuString);
                    } else {
                        $authorized = false;
                    }
                }

                $menu_caret = (!empty($submenu) ? $templates['menu_caret'] : '');
                $link = sprintf($templates['menu_link'],
                    (!empty($menu->route) ? url($menu->route) : '#'),
                    (!empty($menu->icon) ? $menu->icon : 'fa fa-circle-o'),
                    //trans('back-project::base.dashboard')
                    \Lang::has('back-project::menu.' . $menu->title) ? __('back-project::menu.' . $menu->title) : $menu->title,
                    $menu_caret
                );
                $class = (!empty($submenu) ? 'treeview' : '');
                $current_url = \Route::current()->uri();

                if ($authorized) {
                    $menuString .= sprintf($templates['menu_row'], $class, $link . $submenu);
                }
            }

            return [
                $menuString,
                $hasActive
            ];
        };

        list($menu, $hasActive) = $traverse($menus);
        return sprintf($templates['menu'], $menu);
    }
}
