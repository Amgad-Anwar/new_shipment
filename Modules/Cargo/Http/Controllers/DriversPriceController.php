<?php

namespace Modules\Cargo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cargo\Http\DataTables\AreasDataTable;
use Modules\Cargo\Http\DataTables\DriversPricesDataTable;
use Modules\Cargo\Http\Requests\PackageRequest;
use Modules\Cargo\Entities\Package;
use Modules\Cargo\Entities\Country;
use Modules\Cargo\Entities\State;
use Modules\Cargo\Entities\Area;
use Modules\Cargo\Http\Requests\AreaRequest;
use Modules\Acl\Repositories\AclRepository;
use Modules\Cargo\Entities\DriversPrice;

class DriversPriceController extends Controller
{

    private $aclRepo;


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(DriversPricesDataTable $dataTable)
    {

        breadcrumb([
            [
                'name' => __('cargo::view.dashboard'),
                'path' => fr_route('admin.dashboard')
            ],
            [
                'name' => __('Drivers prices'),
            ],
        ]);
        $data_with = [];
        $share_data = array_merge(get_class_vars(DriversPricesDataTable::class), $data_with);
        // dd('end');
 
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        return $dataTable->render('cargo::'.$adminTheme.'.pages.drivers_prices.index', $share_data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        breadcrumb([
            [
                'name' => __('cargo::view.dashboard'),
                'path' => fr_route('admin.dashboard')
            ],
            [
                'name' => __('Drivers prices'),
                'path' => fr_route('drivers_prices.index')
            ],
            [
                'name' => __('cargo::view.add_area'),
            ],
        ]);
        $countries = Country::where('covered',1)->get();
        $adminTheme = env('ADMIN_THEME', 'adminLte');return view('cargo::'.$adminTheme.'.pages.drivers_prices.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->only(['desc','name']);
        $area = DriversPrice::create($data);
        return redirect()->route('drivers_prices.index')->with(['message_alert' => __('cargo::messages.created')]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $adminTheme = env('ADMIN_THEME', 'adminLte');return view('cargo::'.$adminTheme.'.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        breadcrumb([
            [
                'name' => __('cargo::view.dashboard'),
                'path' => fr_route('admin.dashboard')
            ],
            [
                'name' => __('Drivers prices'),
                'path' => fr_route('drivers_prices.index')
            ],
            [
                'name' => __('Edit'),
            ],
        ]);
        $area   = DriversPrice::findOrFail($id);
        $adminTheme = env('ADMIN_THEME', 'adminLte');return view('cargo::'.$adminTheme.'.pages.drivers_prices.edit')->with(['model' => $area]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        if (env('DEMO_MODE') == 'On') {
            return redirect()->back()->with(['error_message_alert' => __('view.demo_mode')]);
        }

        $area = DriversPrice::findOrFail($id);
        $data = $request->only(['name', 'desc']);
        $area->update($data);
        return redirect()->route('drivers_prices.index')->with(['message_alert' => __('cargo::messages.saved')]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (env('DEMO_MODE') == 'On') {
            return redirect()->back()->with(['error_message_alert' => __('view.demo_mode')]);
        }

        DriversPrice::destroy($id);
        return response()->json(['message' => __('cargo::messages.deleted')]);
    }


}
