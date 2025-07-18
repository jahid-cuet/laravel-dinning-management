@extends('admin.layouts.master')

@section('title')
    {{ $page_title }}
@endsection
@section('container')
    <div class="trk-table">
        <div class="trk-table__wrapper">


            <div class=" trk-table__header d-flex justify-content-between">
                <div class="trk-table__title">
                    <h5>{{ $info->title }}</h5>
                    <p>{{ $info->description }}</p>
                </div>
                <div class="float-right">
                    @can('dinning-student-create')
                        <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">
                            <i class="flaticon2-add"></i>
                            {{ $info->first_button_title }}
                        </a>
                    @endcan

                    @can('export-view')
                        <a href="{{ request()->fullUrlWithQuery(['export_table' => 1]) }}" class="btn btn-primary">
                            <i class="flaticon2-export"></i>
                            Export
                        </a>
                    @endcan
                </div>
            </div>


            <div class="trk-table__body">
                <div class="table__top mt-4">
                    <div class="table__top-dropdown">
                        <label>
                            <select class="selector" name="per_page" id="per_page" onchange="filterPerPage(this)">
                                <option value="5" @if ($per_page == 5) selected @endif>5</option>
                                <option value="10" @if ($per_page == 10) selected @endif>10</option>
                                <option value="15" @if ($per_page == 15) selected @endif>15</option>
                                <option value="20" @if ($per_page == 20) selected @endif>20</option>
                                <option value="25" @if ($per_page == 25) selected @endif>25</option>
                            </select> entries per page
                        </label>
                    </div>
                    <div class="table__top-search">
                        <div class="input-group">
                            <input type="text" id="search" class="form-control" placeholder="Search..."
                                value="{{ request()->search }}" onkeypress="searchOnEnter(event, this)" aria-label="Search">
                        </div>
                    </div>
                </div>
                @if ($data->count() > 0)
                    <!--begin: Datatable-->
                    <table class="table" id="">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Avatar</th>
                                <th>Student Id</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Session</th>
                                <th>Meals</th>
                                <th>Duration</th>
                                <th>Txid</th>
                                {{-- <th>Dinning Month</th> --}}
                                <th>Is Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $serial = 1;
                            @endphp

                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $serial }}
                                    </td>
                                    <td>
                                        <div class="trk-item d-flex gap-2">
                                            <div class="trk-thumb thumb-md">
                                                <img src="@if ($row->avatar != '') {{ asset($row->avatar) }} @else {{ asset(avatarUrl()) }} @endif"
                                                    alt="avatar">
                                            </div>
                                        </div>


                                    </td>
                                    <td>{{ $row->student_id }}
                                    </td>
                                    <td>{{ $row->name }}
                                    </td>
                                    <td>{{ $row->department?->name }}
                                    </td>
                                      <td>{{ $row->studentSession?->name }} <br>
                                        {{ $row->studentSession?->hsc_session }}
                                    </td>
                                    <td>{{ $row->total_meals }} ({{$row->dinningMonth?->meal_rate * $row->total_meals}} Tk)
                                    </td>
                                     <td>
                                        <span class="text-dark-75 font-weight-bold d-block font-size-lg">
                                            @if ($row->from && $row->to)
                                                {{ date('d-m-Y', strtotime($row->from)) }} -
                                                {{ date('d-m-Y', strtotime($row->to)) }}
                                            @else
                                                n/a
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $row->txid }}
                                    </td>
                                    
                                   

                                    {{-- <td>{{ $row->dinningMonth?->title }} --}}


                                    </td>

                                  
                                    <td>
                                        <div class="form-check form-switch form-switch-md">
                                            <input type="checkbox" name="is_active" value="{{ $row->id }}"
                                                onclick="toggleSwitchStatus(this,'dinning_students');"
                                                class="form-check-input" @if ($row->is_active == 1) checked @endif>
                                        </div>



                                    </td>
                                    <td>
                                        <ul class="trk-action__list">
                                            <li class="trk-action">
                                                <a class="trk-action__item trk-action__item--success"
                                                    href="{{ route('admin.dinning-students.show', $row->id) }}">
                                                    <i class="lni lni-eye"></i>
                                                </a>
                                            </li>
                                            @can('dinning-student-update')
                                                <li class="trk-action">
                                                    <a class="trk-action__item trk-action__item--warning"
                                                        href="{{ route('admin.dinning-students.edit', $row->id) }}">
                                                        <i class="lni lni-pencil-alt"></i>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('dinning-student-delete')
                                                <li class="trk-action">
                                                    <a onclick="deleteCrudItem(`{{ route('admin.dinning-students.destroy', $row->id) }}`)"
                                                        class="trk-action__item trk-action__item--danger" href="#">
                                                        <i class="lni lni-trash-can"></i>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>

                                    </td>
                                </tr>
                                @php
                                    $serial++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>

                    {{ $data->appends(request()->input())->links() }}
                    <!--end: Datatable-->
                @else
                    <div class="alert alert-custom alert-notice alert-light-success fade show mb-5 text-center"
                        role="alert">
                        <div class="alert-icon">
                            <i class="flaticon-questions-circular-button"></i>
                        </div>
                        <div class="alert-text text-dark">
                            No Data Found..!
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
    @include('admin.components.modals.delete')
@endsection

@section('css')
@endsection
@section('js')
    @parent
    {{-- SCRIPT --}}
@endsection
