@extends('layouts.app')

@section('content')
<div class="row g-0 justify-content-center">
    <div class="col-12 col-md-10">
        <div class="card border-0 bg-transparent">
            <div class="card-header bg-transparent border-0 row d-flex align-items-center p-0">
                <div class="col-12 col-md-11">
                    <h1 class="text-primary">
                        {{ $page_title }}
                    </h1>
                </div>
                <div class="col-12 col-md-1">
                    <a class="btn btn-primary border-0 w-100" href="{{route('employee.create')}}" role="button" >
                        <i class="fas fa-plus-square"></i>
                    </a>
                </div>
            </div>
            <div class="card-body border-0 px-0">
                <div class="w-100 p-3">
                    <div class="form-group">
                       <select class="form-select" id="filter_company" name="filter_company" >
                            <option value="">{{ trans('messages.employee_list_filter_company_text') }}</option>
                            @foreach ($company_data as $each_company_id=>$each_company_name)
                                <option value="{{ $each_company_id }}">{{ $each_company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="employeelist" class="table table-sm table-bordered">
                        <thead>
                            <th>{{ trans('messages.employee_list_column_fullname_text') }}</th>
                            <th>{{ trans('messages.employee_list_column_emailaddress_text') }}</th>
                            <th>{{ trans('messages.employee_list_column_company_name_text') }}</th>
                            <th>{{ trans('messages.employee_list_column_status_text') }}</th>
                            <th>{{ trans('messages.company_list_column_action_text') }}</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customscript')
<script type="text/javascript">
    var employeedataTable;
    jQuery(document).ready(function($) {
        employeedataTable = jQuery('#employeelist').DataTable({
            processing: true,
            serverSide: true,
            autoWidth : false,
            pageLength: 10,
            "order"   : [[ 0, "asc" ]],
            ajax      : {
                url: "{{ route('employee.employee_ajax') }}",
                data: function (d) {
                    d.filter_company = jQuery('#filter_company').val()
                }
            },
            columns   : [
                {data: 'fullname', name: 'fullname'},
                {data: 'email_address', name: 'email_address'},
                {data: 'company_name', name: 'company_name'},
                {data: 'status', name: 'status',serachable:false,sClass:'text-center'},
                {data: 'actions', name: 'actions',orderable:false,serachable:false,sClass:'text-center'},
            ],
            drawCallback : function (settings){
                jQuery('[data-bs-toggle="tooltip"]').tooltip();
                jQuery('[data-bs-toggle="popover"]').popover();
            }
        });
        jQuery(document).on('click', '.delete_employee', function(event) {
            event.preventDefault();
            var eleId = parseInt(jQuery(this).attr('id').split('delete_employee_')[1]);
            if (eleId > 0) {
                jQuery.ajax({
                    url    : "employee/"+eleId,
                    method : 'DELETE',
                    success: function(result) {
                        location.reload();
                    }
                });
            }
        });

        jQuery(document).on('change', '#filter_company', function(event) {
            employeedataTable.draw();
        });
    });
</script> 
@endsection
