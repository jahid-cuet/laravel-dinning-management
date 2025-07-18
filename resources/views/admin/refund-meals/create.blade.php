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
        <label class="form-label" for="meal_date">Meal Date  <span>&#x002A;</span> </label>
        <input 
        type="date" 
        class="form-control flatpickr @error('meal_date') is-invalid @enderror" 
        id="meal_date" 
        name="meal_date"
        placeholder="Select Date"
                    value="{{old("meal_date")}}"                required
        >
        @error('meal_date')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <div class="form-check form-switch">
            <input 
            class="form-check-input @error('lunch') is-invalid @enderror" 
            type="checkbox" 
            name="lunch"
            id="lunch"
             
                                    @if(old('lunch') == 1) checked @endif                             
                        >
            <label class="form-check-label" for="lunch">Lunch </label>
            @error('lunch')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <div class="form-check form-switch">
            <input 
            class="form-check-input @error('dinner') is-invalid @enderror" 
            type="checkbox" 
            name="dinner"
            id="dinner"
             
                                    @if(old('dinner') == 1) checked @endif                             
                        >
            <label class="form-check-label" for="dinner">Dinner </label>
            @error('dinner')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>
</div>
<div class="col-md-6">

    <div class="form-group">
        <label class="form-label" for="refund_request_id">&#039;refund Request </label>
        <select 
            class="form-select search-select @error('refund_request_id') is-invalid @enderror" 
            data-live-search="true"
            id="refund_request_id" 
            name="refund_request_id" 
            
            
        >
            <option value="">--Choose--</option>
                            @foreach(activeModelData('App\Models\RefundRequest') as $row)                                    
                    <option value="{{$row->id}}" @if(old("refund_request_id")==$row->id) selected @endif>{{$row->total_meal}}</option>
                                                    @endforeach                    </select>
        @error('refund_request_id')            <div class="invalid-feedback">{{ $message }}</div>
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
