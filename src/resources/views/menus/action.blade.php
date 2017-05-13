<div class="list-group-item">
    <div class="row">
        <div class="col-md-2">
            {{ $menu->name }}
        </div>

        <div class="col-md-2">
            {{ $menu->title }}
        </div>

        <div class="col-md-2">
            {{ $menu->route }}
        </div>

        <div class="col-md-2">
            {{ $menu->icon }}
        </div>

        <div class="col-md-2">
            {{ $menu->permission }}
        </div>

        <div class="col-md-2">
            @component('back-project::components.generic-button-link', [
                'icon' => 'edit',
                'url' => route('menus.edit', $menu->id),
                'color' => 'default',
                'class' => 'xs'
            ])
            @endcomponent

            @component('back-project::components.generic-button-link', [
                'icon' => 'delete',
                'url' => route('menus.delete', $menu->id),
                'color' => 'danger',
                'action' => 'delete',
                'class' => 'xs'
            ])
            @endcomponent

            @component('back-project::components.generic-button-link', [
                'icon' => 'up',
                'url' => route('menus.up', $menu->id),
                'color' => 'primary',
                'class' => 'xs'
            ])
            @endcomponent

            @component('back-project::components.generic-button-link', [
                'icon' => 'down',
                'url' => route('menus.down', $menu->id),
                'color' => 'primary',
                'class' => 'xs'
            ])
            @endcomponent
        </div>

    </div>
</div>