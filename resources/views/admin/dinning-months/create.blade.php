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
                        <form class="form" action="{{ route($info->form_route) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Title <span>&#x002A;</span> </label>
                                        <input type="text" value="{{ old('title') }}"
                                            class="form-control @error('title') is-invalid @enderror" id="title"
                                            name="title" placeholder="Enter Title" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="meal_rate">Meal Rate <span>&#x002A;</span> </label>
                                        <input type="number" value="{{ old('meal_rate') }}"
                                            class="form-control @error('meal_rate') is-invalid @enderror" id="meal_rate"
                                            name="meal_rate" placeholder="Enter Meal Rate" required>
                                        @error('meal_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="from">From <span>&#x002A;</span> </label>
                                        <input type="date"
                                            class="form-control flatpickr @error('from') is-invalid @enderror"
                                            id="from" name="from" placeholder="Select Date"
                                            value="{{ old('from') }}" required>
                                        @error('from')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="to">To <span>&#x002A;</span> </label>
                                        <input type="date"
                                            class="form-control flatpickr @error('to') is-invalid @enderror" id="to"
                                            name="to" placeholder="Select Date" value="{{ old('to') }}" required>
                                        @error('to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="form-label" for="user_id">User </label>
                                        <select class="form-select search-select @error('user_id') is-invalid @enderror"
                                            data-live-search="true" id="user_id" name="user_id">
                                            <option value="">--Choose--</option>
                                            @foreach (activeModelData('App\Models\User') as $row)
                                                <option value="{{ $row->id }}"
                                                    @if (old('user_id') == $row->id) selected @endif>{{ $row->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div> --}}
                                <div class="col-md-6">

                                    {{-- <div class="form-group">
                                        <label class="form-label" for="dinning_student_id">Dinning Manager
                                            <span>&#x002A;</span> </label>
                                        <select
                                            class="form-select search-select @error('dinning_student_id') is-invalid @enderror"
                                            data-live-search="true" id="dinning_student_id" name="dinning_student_id"
                                            required>
                                            <option value="">--Choose--</option>
                                            @foreach (activeModelData('App\Models\DinningStudent') as $row)
                                                <option value="{{ $row->id }}"
                                                    @if (old('dinning_student_id') == $row->id) selected @endif>{{ $row->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dinning_student_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group">
    <label class="form-label" for="dinning_student_id">Dinning Manager <span>&#x002A;</span></label>
    <select
        class="form-select search-select @error('dinning_student_id') is-invalid @enderror"
        data-live-search="true"
        id="dinning_student_id"
        name="dinning_student_id"
        {{ count($students) == 0 ? 'disabled' : '' }}
        required
    >
        <option value="">--Choose--</option>
        @foreach ($students as $row)
            <option value="{{ $row->id }}"
                @if (old('dinning_student_id') == $row->id) selected @endif>
                {{ $row->name }}
            </option>
        @endforeach
    </select>

    @error('dinning_student_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(count($students) == 0)
        <small class="text-danger mt-2">⚠️ No students available. Please add students first to assign a dining manager.</small>
    @endif
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

    {{-- SCRIPT --}}
@endsection
