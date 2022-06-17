<?php

namespace Mohan9a\AdminlteNav\Models;

use Illuminate\Support\Str;
use Mohan9a\AdminlteNav\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    
    protected $table = 'menus';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }


    public function parent_items()
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id');
    }

    /**
     * Display menu.
     *
     * @param string      $menuName
     * @param string|null $type
     * @param array       $options
     *
     * @return string
     */
    public static function display($menuName, $type = null, array $options = [])
    {
        // GET THE MENU - sort collection in blade
        $menu = static::where('name', '=', $menuName)
                ->with(['parent_items.children' => function ($q) {
                    $q->orderBy('order');
                }])
                ->first();

        // Check for Menu Existence
        if (!isset($menu)) {
            return false;
        }

        // Convert options array into object
        $options = (object) $options;

        $items = $menu->parent_items->sortBy('order');

        if ($menuName == 'admin' && $type == '_json') {
            $items = static::processItems($items);
        }

        if ($type == 'admin') {
            $type = 'adminltenav::menus.'.$type;
        } else {
            $type = 'bootstrap';
            if (is_null($type)) {
                $type = 'adminltenav::menus.public.default';
            } elseif ($type == 'bootstrap3' && !view()->exists($type)) {
                $type = 'adminltenav::menus.public.bootstrap3';
            } elseif ($type == 'bootstrap' && !view()->exists($type)) {
                $type = 'adminltenav::menus.public.bootstrap';
            }
        }

        if (!isset($options->locale)) {
            $options->locale = app()->getLocale();
        }

        if ($type === '_json') {
            return $items;
        }
        
        return new \Illuminate\Support\HtmlString(
            \Illuminate\Support\Facades\View::make($type, ['items' => $items, 'options' => $options])->render()
        );
    }

    protected static function processItems($items)
    {
        // Eagerload Translations
        // if (config('voyager.multilingual.enabled')) {
        //     $items->load('translations');
        // }

        $items = $items->transform(function ($item) {
            // Translate title
            $item->title = $item->getTranslatedAttribute('title');
            // Resolve URL/Route
            $item->href = $item->link(true);

            if ($item->href == url()->current() && $item->href != '') {
                // The current URL is exactly the URL of the menu-item
                $item->active = true;
            } elseif (Str::startsWith(url()->current(), Str::finish($item->href, '/'))) {
                // The current URL is "below" the menu-item URL. For example "admin/posts/1/edit" => "admin/posts"
                $item->active = true;
            }
            if (($item->href == url('') || $item->href == route('voyager.dashboard')) && $item->children->count() > 0) {
                // Exclude sub-menus
                $item->active = false;
            } elseif ($item->href == route('voyager.dashboard') && url()->current() != route('voyager.dashboard')) {
                // Exclude dashboard
                $item->active = false;
            }

            if ($item->children->count() > 0) {
                $item->setRelation('children', static::processItems($item->children));

                if (!$item->children->where('active', true)->isEmpty()) {
                    $item->active = true;
                }
            }

            return $item;
        });

        // Filter items by permission
        $items = $items->filter(function ($item) {
            return !$item->children->isEmpty() || Auth::user()->can('browse', $item);
        })->filter(function ($item) {
            // Filter out empty menu-items
            if ($item->url == '' && $item->route == '' && $item->children->count() == 0) {
                return false;
            }

            return true;
        });

        return $items->values();
    }

}
