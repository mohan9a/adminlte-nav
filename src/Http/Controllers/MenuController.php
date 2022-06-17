<?php

namespace Mohan9a\AdminlteNav\Http\Controllers;

use Illuminate\Support\Arr;
use Mohan9a\AdminlteNav\Models\Menu;
use Illuminate\Http\Request;
use Mohan9a\AdminlteNav\Models\MenuItem;
use App\Http\Controllers\Controller;
use Form;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$menus = Menu::paginate(1);
        //return view('adminltenav::menus.index',compact('menus'));
        $menus = Menu::paginate(5);
        return view('adminltenav::menus.index',compact('menus'))
        ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminltenav::menus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        
        Menu::create([
            'name' => $request->input('name')
        ])->id;

        return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Backend\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Backend\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        // $menu = Menu::find($menu)->first();
        // dd($menu);
        return view('adminltenav::menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Backend\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate(['name' => 'required']);
        $input = $request->all();
        $menu->update($input);
        return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Backend\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu = Menu::find($menu->id);
        $menu->delete();
        return response()->json([
            'success' => 'Menu deleted successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Backend\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function builder($id)
    {
        $menu = Menu::findOrFail($id);
        return view('adminltenav::menus.builder',compact('menu'));
    }

    public function order_item(Request $request)
    {
        $menuItemOrder = json_decode($request->input('order'));

        $this->orderMenu($menuItemOrder, null);
    }

    private function orderMenu(array $menuItems, $parentId)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item = MenuItem::findOrFail($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parentId;
            $item->save();

            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }

    /**
     * Menu Items Add
     */
    public function add_item(Request $request)
    {
        $menu = new Menu;

        $data = $this->prepareParameters(
            $request->all()
        );

        unset($data['id']);
        $menuitem = new MenuItem;
        $data['order'] = $menuitem->highestOrderMenuItem();

        // Check if is translatable
        // $_isTranslatable = is_bread_translatable(Voyager::model('MenuItem'));
        // if ($_isTranslatable) {
        //     // Prepare data before saving the menu
        //     $trans = $this->prepareMenuTranslations($data);
        // }

        $menuItem = MenuItem::create($data);

        // Save menu translations
        // if ($_isTranslatable) {
        //     $menuItem->setAttributeTranslations('title', $trans, true);
        // }

        return redirect()
            ->route('menus.builder', [$data['menu_id']])
            ->with([
                'message'    => 'Menu item addess successfully!',
                'alert-type' => 'success',
            ]);
    }

    protected function prepareParameters($parameters)
    {
        switch (Arr::get($parameters, 'type')) {
            case 'route':
                $parameters['url'] = null;
                break;
            default:
                $parameters['route'] = null;
                $parameters['parameters'] = '';
                break;
        }

        if (isset($parameters['type'])) {
            unset($parameters['type']);
        }

        return $parameters;
    }

    public function update_item(Request $request)
    {
        $id = $request->input('id');
        $data = $this->prepareParameters(
            $request->except(['id'])
        );

        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update($data);

        return redirect()
            ->route('menus.builder', [$menuItem->menu_id])
            ->with([
                'message'    => 'Menus updated successfully!',
                'alert-type' => 'success',
            ]);
    }

    public function delete_menu($menu, $id)
    {
        $item = MenuItem::findOrFail($id);
        $item->destroy($id);

        return redirect()
            ->route('menus.builder', [$menu])
            ->with([
                'message'    => 'Menu item deleted successfully!',
                'alert-type' => 'success',
            ]);
    }

}
