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
                    <a class="btn btn-primary border-0 w-100" href="{{route('company.create')}}" role="button" >
                        <i class="fas fa-plus-square"></i>
                    </a>
                </div>
            </div>
            <div class="card-body border-0 px-0">
                <div class="table-responsive">
                    <table id="companylist" class="table table-sm table-bordered">
                        <thead>
                            <th>{{ trans('messages.company_list_column_company_name_text') }}</th>
                            <th>{{ trans('messages.company_list_column_company_type_text') }}</th>
                            <th>{{ trans('messages.company_list_column_action_text') }}</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customscript')
<script type="text/javascript">
    var companydataTable;
    jQuery(document).ready(function($) {
        companydataTable = jQuery('#companylist').DataTable({
            processing: true,
            serverSide: true,
            autoWidth : false,
            pageLength: 10,
            "order"   : [[ 0, "asc" ]],
            ajax      : "{{ route('company.company_ajax') }}",
            columns   : [
                {data: 'company_name', name: 'company_name'},
                {data: 'company_type', name: 'company_type'},
                {data: 'actions', name: 'actions',orderable:false,serachable:false,sClass:'text-center'},
            ],
            drawCallback : function (settings){
                jQuery('[data-bs-toggle="tooltip"]').tooltip();
                jQuery('[data-bs-toggle="popover"]').popover();
            }
        });
        jQuery(document).on('click', '.delete_company', function(event) {
            event.preventDefault();
            var eleId = parseInt(jQuery(this).attr('id').split('delete_company_')[1]);
			if (eleId > 0) {
                jQuery.ajax({
                    url    : "company/"+eleId,
                    method : 'DELETE',
                    success: function(result) {
                        location.reload();
                    }
                });
            }
        });
    });
</script> 
@endsection
