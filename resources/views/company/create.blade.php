@extends('layouts.app')

@section('content')
<div class="row g-0 justify-content-center">
    <div class="col-12 col-md-10">
        <div class="card border-0 bg-transparent">
            <form action="{{ route('company.store') }}" class="needs-validation" method="POST" novalidate name="company_create_form" id="company_create_form" >
                <div class="card-header bg-transparent border-0 row d-flex align-items-center p-0">
                    <div class="col-12 col-md-11">
                        <h1 class="text-primary">
                            {{ $page_title }}
                        </h1>
                    </div>
                    <div class="col-12 col-md-1">
                        <a class="btn btn-dark border-0 w-100" href="{{route('company.index')}}" role="button" >
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body border-0 px-0">
                    <div class="row">
                        <div class="mb-3 col-12 col-md-6">
                            <label for="company_name" class="form-label fw-bold">
                                {{ trans('messages.companies_form_field_company_name_text') }}<strong class="text-danger">*</strong>
                            </label>
                            <input type="text" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" id="company_name" name="company_name" value="{{ old('company_name') }}" />
                            @if ($errors->has('company_name'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('company_name') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="company_type" class="form-label fw-bold">
                                {{ trans('messages.companies_form_field_company_type_text') }}
                            </label>
                            <select class="form-select{{ $errors->has('company_type') ? ' is-invalid' : '' }}" id="company_type" name="company_type" >
                                <option value="0"></option>
                                <option value="1" @if(old('company_type') == 1){{ ' selected="selected"' }}@endif >{{trans('messages.companies_form_field_type_public_limited_option_text')}}</option>
                                <option value="2" @if(old('company_type') == 2){{ ' selected="selected"' }}@endif >{{trans('messages.companies_form_field_type_private_limited_option_text')}}</option>
                                <option value="2" @if(old('company_type') == 3){{ ' selected="selected"' }}@endif >{{trans('messages.companies_form_field_type_registered_company_option_text')}}</option>
                            </select>
                            @if ($errors->has('company_type'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('company_type') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12  col-md-6">
                            <label for="website" class="form-label fw-bold">
                                {{ trans('messages.companies_form_field_website_text') }}
                            </label>
                            <input type="text" class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" id="website" name="website" value="{{ old('website') }}" />
                            @if ($errors->has('website'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('website') }}</small>
                            @endif
                        </div>
                        <div class="mb-3 col-12">
                            <label for="company_description" class="form-label fw-bold">
                                {{ trans('messages.companies_form_field_company_description_text') }}
                            </label>
                            <textarea class="form-control{{ $errors->has('company_description') ? ' is-invalid' : '' }}"
                                name="company_description" id="company_description" rows="3">@if(old('company_description')){{ old('company_description') }}@endif</textarea>
                            @if ($errors->has('company_description'))
                                <small class="invalid-feedback fw-bold fst-italic" role="alert">{{ $errors->first('company_description') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent p-0 d-grid gap-1">
                    <button class="btn btn-primary fw-bold border-0 text-white" type="submit" style="outline: none;">
                        {{ trans('messages.company_create_form_submit_btn_text') }}
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection