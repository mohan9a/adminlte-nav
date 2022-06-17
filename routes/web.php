<?php
use Illuminate\Support\Facades\Route;
use Mohan9a\AdminlteNav\Http\Controllers\MenuController;

Route::get('menus/{id}/builder',[MenuController::class, 'builder'])->name('menus.builder'); //always define before resource route
Route::post('order', [MenuController::class, 'order_item'])->name('menus.order_item'); //always define before resource route;
//menu items
Route::post('menus/{menu}/item', [MenuController::class, 'add_item'])->name('menus.item.add'); //always define before resource route;
Route::put('menus/{menu}/item', [MenuController::class, 'update_item'])->name('menus.item.update'); //always define before resource route;
Route::delete('menus/{menu}/item/{id}', [MenuController::class, 'delete_menu'])->name('menus.item.destroy'); //always define before resource route;
//crud
Route::resource('menus', MenuController::class);
?>