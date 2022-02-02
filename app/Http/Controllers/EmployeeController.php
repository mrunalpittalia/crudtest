<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateEmployee;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();

        $company_data = Company::orderByRaw(\DB::Raw("CAST(company_name as UNSIGNED) ASC "))
            ->orderBy('company_name', 'ASC')
            ->select('company_id', 'company_name')
            ->pluck('company_name', 'company_id')->all();

        $page_title = trans('messages.employee_list_page_title');
        return view('employee.index', compact(
            'now', 'page_title', 'company_data'
        ));
    }

    /**
     * An AJAX function to return list of employees in json format.
     *
     * @param Request $request
     * @return void
     */
    public function employee_ajax(Request $request)
    {
        //if($request->ajax()){
           // echo '<pre />'; print_r($request->post()); exit;
            $employee_data = Employee::orderByRaw(\DB::Raw("CAST(first_name as UNSIGNED) ASC "))
                ->orderBy('first_name', 'ASC')
                ->orderByRaw(\DB::Raw("CAST(last_name as UNSIGNED) ASC "))
                ->orderBy('last_name', 'ASC')
                ->has('company')
                ->with('company')
                ->get();

            $employee_datatable = \DataTables::of($employee_data)
                ->only([
                    'fullname',
                    'email_address',
                    'company_name',
                    'company_id',
                    'status',
                    'actions'
                ])
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('filter_company'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if ($row['company_id'] == $request->get('filter_company')) {
                                return true;
                            }
                            return false;
                        });
                    }

                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        if ($search['value'] != '') {
                            $search_term = $search['value'];
                            $instance->collection = $instance->collection->filter(function ($row) use ($search_term) {
                                if (Str::contains($row['email_address'], $search_term)) {
                                    return true;
                                }elseif (Str::contains($row['fullname'], $search_term)) {
                                    return true;
                                }
                                return false;
                            });
                        }
                   }
                })
                ->editColumn('fullname', function($each_employee){
                    return $each_employee->first_name.' '.$each_employee->last_name;
                })
                ->editColumn('company_name', function($each_employee){
                    return $each_employee->company->company_name;
                })
                ->editColumn('status', function($each_employee){
                    $status_html = '<i class="fas fa-toggle-on text-primary"></i>';
                    if ($each_employee->status == 0) {
                        $status_html = '<i class="fas fa-toggle-off text-primary"></i>';
                    }
                    return $status_html;
                })
                ->addColumn('actions', function($each_employee) {
                    return '<a href="'.route("employee.edit", $each_employee->employee_id).'" style="text-decoration: none;"
                                data-bs-toggle="tooltip"  title="'.trans('messages.employee_list_action_edit_text').'" class="mx-1 text-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="text-danger small fw-bold" href="JavaScript:void(0);" tabindex="0" style="text-decoration: none;"
                                data-bs-trigger="focus" data-bs-html="true" data-bs-toggle="popover"
                                data-bs-title="'.trans('messages.employee_list_action_delete_tooltip_delete_text').'" 
                                data-bs-content="<div class=\'text-center\'><a role=\'button\' class=\'delete_employee btn btn-danger w-100\' id=\'delete_employee_'.$each_employee->employee_id.'\'>'.trans('messages.employee_list_action_delete_tooltip_delete_btn_title').'</a></div>" >
                                <i class="fas fa-trash-alt"></i>
                            </a>';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);

            return $employee_datatable;
       //}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $now = Carbon::now();

        $company_data = Company::orderByRaw(\DB::Raw("CAST(company_name as UNSIGNED) ASC "))
            ->orderBy('company_name', 'ASC')
            ->select('company_id', 'company_name')
            ->pluck('company_name', 'company_id')->all();
        if (count($company_data) == 0) {
            $sys_messages = session('sys_messages.danger', array());
            $sys_messages[] = trans('messages.employee_create_edit_no_company_exist_msg');
            session(['sys_messages.danger' => $sys_messages]);
            return redirect()->route('employee.index');
        }

        $page_title = trans('messages.employee_create_page_title');
        return view('employee.create', compact(
            'now', 'page_title', 'company_data'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateEmployee $request)
    {
        $company_data = Company::orderByRaw(\DB::Raw("CAST(company_name as UNSIGNED) ASC "))
            ->orderBy('company_name', 'ASC')
            ->select('company_id', 'company_name')
            ->pluck('company_name', 'company_id')->all();
        if (count($company_data) == 0) {
            $sys_messages = session('sys_messages.danger', array());
            $sys_messages[] = trans('messages.employee_create_edit_no_company_exist_msg');
            session(['sys_messages.danger' => $sys_messages]);
            return redirect()->route('employee.index');
        }

        $post_data = $request->validated();
        
        try {
            Employee::create($post_data);
        } catch (\Exception $exception) {
            logger()->error($exception);

            $sys_messages = session('sys_messages.danger', array());
            $sys_messages[] = trans('messages.employee_create_fail_msg');
            session(['sys_messages.danger' => $sys_messages]);
            return redirect()->route('employee.create');
        }

        $sys_messages = session('sys_messages.success', array());
        $sys_messages[] = trans('messages.employee_create_success_msg');
        session(['sys_messages.success' => $sys_messages]);
        return redirect()->route('employee.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $now = Carbon::now();

        $company_data = Company::orderByRaw(\DB::Raw("CAST(company_name as UNSIGNED) ASC "))
            ->orderBy('company_name', 'ASC')
            ->select('company_id', 'company_name')
            ->pluck('company_name', 'company_id')->all();
        if (count($company_data) == 0) {
            $sys_messages = session('sys_messages.danger', array());
            $sys_messages[] = trans('messages.employee_create_edit_no_company_exist_msg');
            session(['sys_messages.danger' => $sys_messages]);
            return redirect()->route('employee.index');
        }

        $page_title = trans('messages.employee_edit_page_title', ['EMPLOYEE_FULLNAME' => $employee->first_name.''.$employee->first_name]);
        return view('employee.edit', compact(
            'now', 'page_title', 'employee', 'company_data'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateEmployee $request, Employee $employee)
    {
        $post_data = $request->all();

        try {
            $employee->update($post_data);
        } catch (\Exception $exception) {
            logger()->error($exception);

            $sys_messages = session('sys_messages.danger', array());
            $sys_messages[] = trans('messages.employee_edit_fail_msg');
            session(['sys_messages.danger' => $sys_messages]);
            return redirect()->route('employee.edit', [$employee->employee_id]);
        }

        $sys_messages = session('sys_messages.success', array());
        $sys_messages[] = trans('messages.employee_edit_success_msg');
        session(['sys_messages.success' => $sys_messages]);
        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
        } catch (\Exception $exception) {
            logger()->error($exception);

            $sys_messages = session('sys_messages.danger', array());
            $sys_messages[] = trans('messages.employee_delete_fail_msg');
            session(['sys_messages.danger' => $sys_messages]);
            return response()->json(['success'=> false ]);
        }

        $sys_messages = session('sys_messages.success', array());
        $sys_messages[] = trans('messages.employee_delete_success_msg');
        session(['sys_messages.success' => $sys_messages]);
        return response()->json(['success'=>true]);
    }
}
