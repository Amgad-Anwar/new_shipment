<?php

namespace Modules\Cargo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\Cargo\Http\DataTables\AreasDataTable;
use Modules\Cargo\Http\DataTables\DriverPriceLayersDataTable;
use Modules\Cargo\Http\Requests\PackageRequest;
use Modules\Cargo\Entities\Package;
use Modules\Cargo\Entities\Country;
use Modules\Cargo\Entities\State;
use Modules\Cargo\Entities\Area;
use Modules\Cargo\Http\Requests\AreaRequest;
use Modules\Acl\Repositories\AclRepository;
use Modules\Cargo\Entities\DriversPriceLayer;

class DriversPriceLayerController extends Controller
{

    private $aclRepo;



    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index( $drivers_price_id , DriverPriceLayersDataTable $dataTable)
    {
        Session::put('drivers_price_id' , $drivers_price_id );
        breadcrumb([
            [
                'name' => __('cargo::view.dashboard'),
                'path' => fr_route('admin.dashboard')
            ],
            [
                'name' => __('Driver Price'),
                'path' => fr_route('drivers_prices.index')
            ],
            [
                'name' => __('Drivers Prices Layer'),
            ],
        ]);
        $data_with = [];
        $share_data = array_merge(get_class_vars(DriverPriceLayersDataTable::class), $data_with);
        // dd('end');
 
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        return $dataTable->render('cargo::'.$adminTheme.'.pages.drivers_prices_layer.index', $share_data);
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
                'name' => __('Driver Price'),
                'path' => fr_route('drivers_prices.index')
            ],
            [
                'name' => __('Drivers Prices Layer'),
                'path' => fr_route('drivers_prices_layer.index' , Session::get('drivers_price_id' ) )
            ],
            [
                'name' => __('cargo::view.add_area'),
            ],
        ]);
        $states = State::where('country_id',65 )->where('covered',1)->get();
        $adminTheme = env('ADMIN_THEME', 'adminLte');return view('cargo::'.$adminTheme.'.pages.drivers_prices_layer.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request , $drivers_price_id)
    {
        $data = $request->only([
        'from_state_id',
        'to_state_id',
        'from_area_id',
        'to_area_id',
        'amount',
        ]);
        $data['drivers_price_id'] = Session::get('drivers_price_id' ) ;
        $area = DriversPriceLayer::create($data);
        return redirect()->route('drivers_prices_layer.index' , Session::get('drivers_price_id' ) )->with(['message_alert' => __('cargo::messages.created')]);
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
    public function edit( $drivers_price_id , $id)
    {
        breadcrumb([
            [
                'name' => __('cargo::view.dashboard'),
                'path' => fr_route('admin.dashboard')
            ],
            [
                'name' => __('Driver Price'),
                'path' => fr_route('drivers_prices.index')
            ],
            [
                'name' => __('Drivers Prices Layer'),
                'path' => fr_route('drivers_prices_layer.index' , Session::get('drivers_price_id' ) )
            ],
            [
                'name' => __('cargo::view.edit_area'),
            ],
        ]);
        $area   = DriversPriceLayer::findOrFail($id);
        $states = State::where('country_id',65 )->where('covered',1)->get();
        $from_areas = Area::where('state_id' , $area->from_state_id )->get() ;
        $to_areas = Area::where('state_id' , $area->to_state_id )->get() ;
        $adminTheme = env('ADMIN_THEME', 'adminLte');return view('cargo::'.$adminTheme.'.pages.drivers_prices_layer.edit')->with(['model' => $area, 'states' => $states , 'from_areas'=>$from_areas ,'to_areas'=>$to_areas ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $drivers_price_id , $id)
    {
        if (env('DEMO_MODE') == 'On') {
            return redirect()->back()->with(['error_message_alert' => __('view.demo_mode')]);
        }

        $area = DriversPriceLayer::findOrFail($id);
        $data = $request->only([
            'from_state_id',
            'to_state_id',
            'from_area_id',
            'to_area_id',
            'amount',
            ]);
        $area->update($data);
        return redirect()->route('drivers_prices_layer.index' , Session::get('drivers_price_id' ) )->with(['message_alert' => __('cargo::messages.saved')]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy( $drivers_price_id , $id)
    {
        if (env('DEMO_MODE') == 'On') {
            return redirect()->back()->with(['error_message_alert' => __('view.demo_mode')]);
        }

        DriversPriceLayer::destroy($id);
        return response()->json(['message' => __('cargo::messages.deleted')]);
    }



}
