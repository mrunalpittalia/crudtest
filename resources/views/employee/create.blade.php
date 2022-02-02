@extends('layouts.app')

@section('content')
<div class="row g-0 justify-content-center">
    <div class="col-12 col-md-10">
        <div class="card border-0 bg-transparent">
            <form action="{{ route('employee.store') }}" class="needs-validation" method="POST" novalidate name="employee_create_form" id="employee_create_form" >
                <div class="card-header bg-transparent border-0 row d-flex align-items-center p-0">
                    <div class="col-12 col-md-11">
                        <h1 class="text-primary">
                            {{ $page_title }}
                        </h1>
                    </div>
                    <div class="col-12 col-md-1">
                        <a class="btn btn-dark border-0 w-100" href="{{route('employee.index')}}" role="button" >
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body border-0 px-0">
                    <div class="row">
                        <div class="mb-3 col-12 col-md-6">
                            <label for="first_name" class="form-label fw-bold">
                                {{ trans('messages.employee_form_field_firstname_text') }}<strong class="text-danger">*</strong>
                            </label>
                            <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" id="first_name" name="first_name" value="{{ old('first_name') }}" />
                            @if ($errors->has('first_name'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('first_name') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="last_name" class="form-label fw-bold">
                                {{ trans('messages.employee_form_field_lastname_text') }}<strong class="text-danger">*</strong>
                            </label>
                            <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" id="last_name" name="last_name" value="{{ old('last_name') }}" />
                            @if ($errors->has('last_name'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('last_name') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="email_address" class="form-label fw-bold">
                                {{ trans('messages.employee_form_field_email_address_text') }}<strong class="text-danger">*</strong>
                            </label>
                            <input type="text" class="form-control{{ $errors->has('email_address') ? ' is-invalid' : '' }}" id="email_address" name="email_address" value="{{ old('email_address') }}" />
                            @if ($errors->has('email_address'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('email_address') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="company_id" class="form-label fw-bold">
                                {{ trans('messages.employee_form_field_company_text') }}<strong class="text-danger">*</strong>
                            </label>
                            <select class="form-select{{ $errors->has('company_id') ? ' is-invalid' : '' }}" id="company_id" name="company_id" >
                                @foreach ($company_data as $each_company_id=>$each_company_name)
                                    <option value="{{ $each_company_id }}" @if(old('company_id') == $each_company_id){{ ' selected="selected"' }}@endif >{{ $each_company_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('company_id'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('company_id') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="position" class="form-label fw-bold">
                                {{ trans('messages.employee_form_field_position_text') }}<strong class="text-danger">*</strong>
                            </label>
                            <input type="text" class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}" id="position" name="position" value="{{ old('position') }}" />
                            @if ($errors->has('position'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('position') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="city" class="form-label fw-bold">
                                {{ trans('messages.employee_form_field_city_text') }}<strong class="text-danger">*</strong>
                            </label>
                            <input type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" id="city" name="city" value="{{ old('city') }}" />
                            @if ($errors->has('city'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('city') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="country" class="form-label fw-bold">
                                {{ trans('messages.employee_form_field_country_text') }}<strong class="text-danger">*</strong>
                            </label>
                            <input type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" id="country" name="country" value="{{ old('country') }}" />
                            @if ($errors->has('country'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('country') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="country" class="form-label fw-bold">
                                {{ trans('messages.employee_form_field_status_text') }}<strong class="text-danger">*</strong>
                            </label>
                            <div class="d-block">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status1" value="1" 
                                        @if(old('status') == 1){{ 'checked="checked"' }}@endif>
                                    <label class="form-check-label" for="status1">{{ trans('messages.employee_form_field_status_enable_text') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status0" value="0" 
                                        @if(old('status') == 0){{ 'checked="checked"' }}@endif >
                                    <label class="form-check-label" for="status0">{{ trans('messages.employee_form_field_status_disable_text') }}</label>
                                </div>
                            </div>
                            @if ($errors->has('status'))
                                <small class="invalid-feedback fw-bold fst-italic d-block" role="alert">{{ $errors->first('status') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent p-0 d-grid gap-1">
                    <button class="btn btn-primary fw-bold border-0 text-white" type="submit" style="outline: none;">
                        {{ trans('messages.employee_create_form_submit_btn_text') }}
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection