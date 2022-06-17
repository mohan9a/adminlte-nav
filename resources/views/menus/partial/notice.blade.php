@if( config('SHOW_DEV_TIPS') || 1==1)
    <div class="container-fluid">
        <div class="alert alert-info">
            <strong>How To Use:</strong>
            <p>You can output this menu anywhere on your site by calling <code>menu('{{ !empty($menu) ? $menu->name : 'name' }}')</code></p>
        </div>
    </div>
@endif
