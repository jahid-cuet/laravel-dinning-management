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
            <label class="form-label" for="hsc_session">Hsc Session </label>
            <input 
                type="text" 
                                    value="{{old("hsc_session")}}"                                class="form-control @error('hsc_session') is-invalid @enderror" 
                id="hsc_session" 
                name="hsc_session" 
                placeholder="Enter Hsc Session"
                
                
            >
            @error('hsc_session')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">

    <div class="form-group">
        <label class="form-label" for="name">Name </label>
        <select 
            class="form-select search-select @error('name') is-invalid @enderror" 
            data-live-search="true"
            id="name" 
            name="name" 
            
            
        >
            <option value="">--Choose--</option>
                                                                
                            <option value="2019-20" @if(old("name")=="2019-20") selected @endif>2019-20</option>
                            
                            <option value="2020-21" @if(old("name")=="2020-21") selected @endif>2020-21</option>
                            
                            <option value="2021-22" @if(old("name")=="2021-22") selected @endif>2021-22</option>
                            
                            <option value="2022-23" @if(old("name")=="2022-23") selected @endif>2022-23</option>
                            
                            <option value="2023-24" @if(old("name")=="2023-24") selected @endif>2023-24</option>
                                                                </select>
        @error('name')            <div class="invalid-feedback">{{ $message }}</div>
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
