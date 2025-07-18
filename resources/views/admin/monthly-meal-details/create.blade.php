{{-- Extends layout --}}
@extends('admin.layouts.master')

@section('title')
{{ $page_title }}
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
                        </div>
                    </div>
                    {{-- Card Header End --}}

                    {{-- Card Body Start --}}
                    <div class="trk-card__body">
                        <form class="form" action="{{ route($info->form_route) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">

                                    <div class="col-md-6">

    <div class="form-group">
        <label class="form-label" for="gender">Gender </label>
        <select 
            class="form-select search-select @error('gender') is-invalid @enderror" 
            data-live-search="true"
            id="gender" 
            name="gender" 
            
            
        >
            <option value="">--Choose--</option>
                                                                
                            <option value="male" @if(old("gender")=="male") selected @endif>Male</option>
                            
                            <option value="female" @if(old("gender")=="female") selected @endif>Female</option>
                                                                </select>
        @error('gender')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror        
    </div>

</div>
<div class="col-md-6">

    <div class="form-group">
        <label class="form-label" for="user_id">User </label>
        <select 
            class="form-select search-select @error('user_id') is-invalid @enderror" 
            data-live-search="true"
            id="user_id" 
            name="user_id" 
            
            
        >
            <option value="">--Choose--</option>
                            @foreach(activeModelData('App\Models\User') as $row)                                    
                    <option value="{{$row->id}}" @if(old("user_id")==$row->id) selected @endif>{{$row->name}}</option>
                                                    @endforeach                    </select>
        @error('user_id')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror        
    </div>

</div>


                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('button.create') }}</button>
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
    
    {{--SCRIPT--}}
@endsection
