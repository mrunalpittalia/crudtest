<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCompany;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();

        $page_title = trans('messages.company_list_page_title');
        return view('company.index', compact(
            'now', 'page_title', 
        ));
    }

    public function company_ajax(Request $request)
    {
        if($request->ajax()){
            $company_data = Company::orderByRaw(\DB::Raw("CAST(company_name as UNSIGNED) ASC "))
                ->orderBy('company_name', 'ASC')
                ->get();

            $company_datatable = \DataTables::of($company_data)
                ->only([
                    'company_name',
                    'company_type',
                    'actions'
                ])
                ->editColumn('company_type', function($each_company){
                    switch ($each_company->company_type) {
                        case 1:
                            return trans('messages.companies_form_field_type_public_limited_option_text');
                            break;
                        
                        case 2:
                            return trans('messages.companies_form_field_type_private_limited_option_text');
                            break;

                        case 3:
                            return trans('messages.companies_form_field_type_registered_company_option_text');
                            break;
                        
                        default:
                            return trans('messages.companies_form_field_type_none_text');
                            break;
                    }
                })
                ->addColumn('actions', function($each_company) {
                    return '<a href="'.route("company.edit", $each_company->company_id).'" style="text-decoration: none;"
                                data-bs-toggle="tooltip"  title="'.trans('messages.company_list_action_edit_text').'" class="mx-1 text-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="text-danger small fw-bold" href="JavaScript:void(0);" tabindex="0" style="text-decoration: none;"
                                data-bs-trigger="focus" data-bs-html="true" data-bs-toggle="popover"
                                data-bs-title="'.trans('messages.company_list_action_delete_tooltip_delete_text').'" 
                                data-bs-content="<div class=\'text-center\'><a role=\'button\' class=\'delete_company btn btn-danger w-100\' id=\'delete_company_'.$each_company->company_id.'\'>'.trans('messages.company_list_action_delete_tooltip_delete_btn_title').'</a></div>" >
                                <i class="fas fa-trash-alt"></i>
                            </a>';
                })
                ->rawColumns(['actions'])
                ->make(true);

            return $company_datatable;
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $now = Carbon::now();

        $page_title = trans('messages.company_create_page_title');
        return view('company.create', compact(
            'now', 'page_title'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateCompany $request)
    {
        $post_data = $request->all();

        try {
            company::create($post_data);
        } catch (\Exception $exception) {
            logger()->error($exception);

            $sys_messages = session('sys_messages.danger', array());
            $sys_messages[] = trans('messages.company_create_fail_msg');
            session(['sys_messages.danger' => $sys_messages]);
            return redirect()->route('company.create');
        }

        $sys_messages = session('sys_messages.success', array());
        $sys_messages[] = trans('messages.company_create_success_msg');
        session(['sys_messages.success' => $sys_messages]);
        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $now = Carbon::now();

        $page_title = trans('messages.company_edit_page_title', ['COMPANY_NAME' => $company->company_name]);
        return view('company.edit', compact(
            'now', 'page_title', 'company'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompany $request, Company $company)
    {
        $post_data = $request->all();

        try {
            $company->update($post_data);
        } catch (\Exception $exception) {
            logger()->error($exception);

            $sys_messages = session('sys_messages.danger', array());
            $sys_messages[] = trans('messages.company_edit_fail_msg');
            session(['sys_messages.danger' => $sys_messages]);
            return redirect()->route('company.edit', [$company->company_id]);
        }

        $sys_messages = session('sys_messages.success', array());
        $sys_messages[] = trans('messages.company_edit_success_msg');
        session(['sys_messages.success' => $sys_messages]);
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        
        try {
            $company->delete();
        } catch (\Exception $exception) {
            logger()->error($exception);

            $sys_messages = session('sys_messages.danger', array());
            $sys_messages[] = trans('messages.company_delete_fail_msg');
            session(['sys_messages.danger' => $sys_messages]);
            return response()->json(['success'=> false ]);
        }

        $sys_messages = session('sys_messages.success', array());
        $sys_messages[] = trans('messages.company_delete_success_msg');
        session(['sys_messages.success' => $sys_messages]);
        return response()->json(['success'=>true]);
    }
}
