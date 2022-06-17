<?php
/**
 * This is custom helper functions loaded using composer.js autoload function
 */
use Mohan9a\AdminlteNav\Models\Menu;
if (!function_exists('menu')) {
    function menu($menuName, $type = null, array $options = []) {
        return Menu::display($menuName, $type, $options);
    }
}