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
            <label class="form-label" for="token_number">Token Number  <span>&#x002A;</span> </label>
            <input 
                type="text" 
                 
                                                                                    value="{{ $data->token_number}}" 
                                                                                    class="form-control @error('token_number') is-invalid @enderror" 
                id="token_number" 
                name="token_number" 
                placeholder="Enter Token Number"
                required
                
            >
            @error('token_number')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">
            <div class="form-group">
            <label class="form-label" for="time_type">Time Type  <span>&#x002A;</span> </label>
            <input 
                type="text" 
                 
                                                                                    value="{{ $data->time_type}}" 
                                                                                    class="form-control @error('time_type') is-invalid @enderror" 
                id="time_type" 
                name="time_type" 
                placeholder="Enter Time Type"
                required
                
            >
            @error('time_type')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">
    <div class="form-group">
        <label class="form-label" for="dinning_date">Dinning Date  <span>&#x002A;</span> </label>
        <input 
        type="date" 
        class="form-control flatpickr @error('dinning_date') is-invalid @enderror" 
        id="dinning_date" 
        name="dinning_date"
        placeholder="Select Date"
                value="{{$data->dinning_date}}"
                required
        >
        @error('dinning_date')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror    </div>
</div>

<div class="col-md-6">
            <div class="form-group">
            <label class="form-label" for="dinning_time">Dinning Time  <span>&#x002A;</span> </label>
            <input 
                type="time" 
                 
                                                                                    value="{{ $data->dinning_time? date("H:i",strtotime($data->dinning_time)):"" }}" 
                                                                                    class="form-control @error('dinning_time') is-invalid @enderror" 
                id="dinning_time" 
                name="dinning_time" 
                placeholder="Enter Dinning Time"
                required
                
            >
            @error('dinning_time')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">

    <div class="form-group">
        <label class="form-label" for="dinning_student_id">Dinning Student </label>
        <select 
            class="form-select search-select @error('dinning_student_id') is-invalid @enderror" 
            data-live-search="true"
            id="dinning_student_id" 
            name="dinning_student_id" 
            
            
        >
            <option value="">--Choose--</option>
                            @foreach(activeModelData('App\Models\DinningStudent') as $row)                                    
                    <option value="{{$row->id}}" @if($data->dinning_student_id==$row->id) selected @endif >{{$row->name}}</option>
                                                    @endforeach                    </select>
        @error('dinning_student_id')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror        
    </div>

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
