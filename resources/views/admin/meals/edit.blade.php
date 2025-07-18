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
                        <form class="form" action="{{ route($info->form_route, $id) }}" method="post"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row g-4">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="meal_date">Meal Date <span>&#x002A;</span> </label>
                                        <input type="date"
                                            class="form-control flatpickr @error('meal_date') is-invalid @enderror"
                                            id="meal_date" name="meal_date" placeholder="Select Date"
                                            value="{{ $data->meal_date }}" required>
                                        @error('meal_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input @error('lunch') is-invalid @enderror"
                                                type="checkbox" name="lunch" id="lunch"
                                                @if ($data->lunch == '1') checked @endif required>
                                            <label class="form-check-label" for="lunch">Lunch <span>&#x002A;</span>
                                            </label>
                                            @error('lunch')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input @error('dinner') is-invalid @enderror"
                                                type="checkbox" name="dinner" id="dinner"
                                                @if ($data->dinner == '1') checked @endif required>
                                            <label class="form-check-label" for="dinner">Dinner <span>&#x002A;</span>
                                            </label>
                                            @error('dinner')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="form-label" for="dinning_student_id">Dinning Student
                                            <span>&#x002A;</span> </label>
                                        <select
                                            class="form-select search-select @error('dinning_student_id') is-invalid @enderror"
                                            data-live-search="true" id="dinning_student_id" name="dinning_student_id"
                                            required>
                                            <option value="">--Choose--</option>
                                            @foreach (activeModelData('App\Models\DinningStudent') as $row)
                                                <option value="{{ $row->id }}"
                                                    @if ($data->dinning_student_id == $row->id) selected @endif>{{ $row->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dinning_student_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    {{-- <div class="form-group">
                                        <label class="form-label" for="dinning_month_id">Dinning Month </label>
                                        <select
                                            class="form-select search-select @error('dinning_month_id') is-invalid @enderror"
                                            data-live-search="true" id="dinning_month_id" name="dinning_month_id">
                                            <option value="">--Choose--</option>
                                            @foreach (activeModelData('App\Models\DinningMonth') as $row)
                                                <option value="{{ $row->id }}"
                                                    @if ($data->dinning_month_id == $row->id) selected @endif>{{ $row->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dinning_month_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

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


    {{-- SCRIPT --}}'
@endsection
