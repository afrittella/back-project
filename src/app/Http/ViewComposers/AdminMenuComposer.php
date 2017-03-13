<?php

namespace Afrittella\BackProject\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Afrittella\BackProject\Repositories\Menus as MenuRepository;

class AdminMenuComposer {

    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
      $this->menuRepository = $menuRepository;
    }

    public function compose(View $view)
    {
        //@TODO insert in another composer
        /*$data = $view->getData();

        if (isset($data['menu_action'])) {
          $menu = $this->menuRepository->findByName($data['menu_action']);
          if (!empty($menu)) {
            $view->with('menu_action', $menu->title);
            $view->with('menu_url', $menu->route);
            if (empty($data['site_title'])) {
               $view->with('site_title', $menu->title);
            }
            if (empty($data['site_description'])) {
              $view->with('site_description', $menu->description);
            }
          } else {
            $view->with('site_title', config('app.name'));
            $view->with('site_description', "");
            $view->with('menu_action', "");
            $view->with('menu_url', "");
          }
        } else {
          if (empty($data['site_title'])) {
            $view->with('site_title', config('app.name'));
          }
          if (empty($data['site_description'])) {
            $view->with('site_description', "");
          }
        }*/
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

        "menu_subrow" => '
          <ul class="treeview-menu">
            %s
          </ul>
        ',

        "menu_link" => '
          <a href="%s"><i class="%s text-red"></i><span>%s</span></a>
        ' // url, icon, title
        ];
        $traverse = function ($rows) use (&$traverse, $templates, $user) {
            $menuString = "";
            $hasActive = false;
            foreach ($rows as $menu) {
              if (!empty($menu->permission) and !$user->hasPermission($menu->permission)) {
                  continue;
              }
              $hasActive = false;
              $link = sprintf($templates['menu_link'],
                (!empty($menu->route) ? url($menu->route) : '#'),
                (!empty($menu->icon) ? $menu->icon : 'fa fa-circle-o'),
                //trans('back-project::base.dashboard')
                __('back-project::menu.'.$menu->title)
              );

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

              $class = (!empty($submenu) ? 'treeview' : '');
              $current_url = \Route::current()->uri();

              if ($authorized) {
                  $menuString .= sprintf($templates['menu_row'], $class, $link.$submenu);
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
