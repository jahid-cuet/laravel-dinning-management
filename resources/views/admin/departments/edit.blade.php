{{-- Extends layout --}}
@extends('admin.layouts.master')

@section('title')
{{ $info->title }}
@endsection

{{-- Content --}}
@section('container')
    <div class="row">
        <div class="col-lg-12">
            <div class="trk-card">
                <div class="trk-card__wrapper">
                    {{-- Card Header Start --}}
                    <div class=" trk-table__header d-flex justify-content-between">
                        <div class="trk-table__title">
                            <h5>{{ $info->title }}</h5>
                        </div>
                        <div class="float-right">
                            <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">

                                <i class="flaticon2-add"></i>

                                {{ $info->first_button_title }}
                            </a>
                            <a href="{{ route($info->second_button_route) }}" class="btn btn-warning">

                                <i class="flaticon2-add"></i>

                                {{ $info->second_button_title }}
                            </a>
                        </div>
                    </div>
                    {{-- Card Header End --}}

                    {{-- Card Body Start --}}
                    <div class="trk-card__body">
                        <form class="form" action="{{ route($info->form_route, $id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row g-4">

                                    <div class="col-md-6">
            <div class="form-group">
            <label class="form-label" for="name">Name  <span>&#x002A;</span> </label>
            <input 
                type="text" 
                 
                                                                                    value="{{ $data->name}}" 
                                                                                    class="form-control @error('name') is-invalid @enderror" 
                id="name" 
                name="name" 
                placeholder="Enter Name"
                required
                
            >
            @error('name')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">
            <div class="form-group">
            <label class="form-label" for="code">Code </label>
            <input 
                type="text" 
                 
                                                                                    value="{{ $data->code}}" 
                                                                                    class="form-control @error('code') is-invalid @enderror" 
                id="code" 
                name="code" 
                placeholder="Enter Code"
                
                
            >
            @error('code')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>



                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('button.update') }}</button>
                                    <button type="reset" class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- Card Body End --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')

    @parent

@endsection

@section('js')

    @parent

    
        {{--SCRIPT--}}'
        
@endsection
