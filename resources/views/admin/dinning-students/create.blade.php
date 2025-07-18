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

                                        <label class="form-label" for="avatar">Avatar
                                        </label>
                                        <div class="admin__thumb-upload">
                                            <div class=" admin__thumb-edit">
                                                <input type='file' class="@error('avatar') is-invalid @enderror"
                                                    id="avatar" name="avatar"
                                                    onchange="imagePreview(this,'image_preview_avatar');"
                                                    accept=".png, .jpg, .jpeg" />
                                                <label for="avatar"></label>
                                            </div>

                                            <div class="admin__thumb-preview">
                                                <div id="image_preview_avatar" class="admin__thumb-profilepreview"
                                                    style="background-image: url( {{ asset(avatarUrl()) }});">
                                                </div>
                                            </div>

                                            @error('avatar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>




                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="student_id">Student Id <span>&#x002A;</span> </label>
                                        <input type="text" value="{{ old('student_id') }}"
                                            class="form-control @error('student_id') is-invalid @enderror" id="student_id"
                                            name="student_id" placeholder="Enter Student Id" required>
                                        @error('student_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Name <span>&#x002A;</span> </label>
                                        <input type="text" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            name="name" placeholder="Enter Name" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="txid">Txid <span>&#x002A;</span> </label>
                                        <input type="text" value="{{ old('txid') }}"
                                            class="form-control @error('txid') is-invalid @enderror" id="txid"
                                            name="txid" placeholder="Enter Txid" required>
                                        @error('txid')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="total_meals">Total Meal <span>&#x002A;</span>
                                        </label>
                                        <input type="number" value="{{ old('total_meals') }}"
                                            class="form-control @error('total_meals') is-invalid @enderror" id="total_meals"
                                            name="total_meals" placeholder="Enter Total Meal" required>
                                        @error('total_meals')
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
                                        <label class="form-label" for="paid_status">Paid Status </label>
                                        <select
                                            class="form-select search-select @error('paid_status') is-invalid @enderror"
                                            data-live-search="true" id="paid_status" name="paid_status">
                                            <option value="">--Choose--</option>

                                            <option value="paid" @if (old('paid_status') == 'paid') selected @endif>Paid
                                            </option>

                                            <option value="unpaid" @if (old('paid_status') == 'unpaid') selected @endif>Unpaid
                                            </option>
                                        </select>
                                        @error('paid_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div> --}}
                                <div class="col-md-6">

                                    {{-- <div class="form-group">
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
                                    </div> --}}

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="form-label" for="dinning_month_id">Dinning Month
                                            <span>&#x002A;</span> </label>
                                        <select
                                            class="form-select search-select @error('dinning_month_id') is-invalid @enderror"
                                            data-live-search="true" id="dinning_month_id" name="dinning_month_id"
                                            required>
                                            <option value="">--Choose--</option>
                                            @foreach (activeModelData('App\Models\DinningMonth') as $row)
                                                <option value="{{ $row->id }}"
                                                    @if (old('dinning_month_id') == $row->id) selected @endif>{{ $row->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dinning_month_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="form-label" for="department_id">Department <span>&#x002A;</span>
                                        </label>
                                        <select
                                            class="form-select search-select @error('department_id') is-invalid @enderror"
                                            data-live-search="true" id="department_id" name="department_id" required>
                                            <option value="">--Choose--</option>
                                            @foreach (activeModelData('App\Models\Department') as $row)
                                                <option value="{{ $row->id }}"
                                                    @if (old('department_id') == $row->id) selected @endif>{{ $row->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="form-label" for="student_session_id">Student Session
                                            <span>&#x002A;</span> </label>
                                        <select
                                            class="form-select search-select @error('student_session_id') is-invalid @enderror"
                                            data-live-search="true" id="student_session_id" name="student_session_id"
                                            required>
                                            <option value="">--Choose--</option>
                                            @foreach (activeModelData('App\Models\StudentSession') as $row)
                                                <option value="{{ $row->id }}"
                                                    @if (old('student_session_id') == $row->id) selected @endif>{{ $row->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('student_session_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <button type="submit"
                                        class="btn btn-primary mt-4">{{ __('button.create') }}</button>
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
