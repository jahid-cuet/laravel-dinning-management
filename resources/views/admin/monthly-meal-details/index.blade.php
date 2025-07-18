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
                    @can('monthly-meal-detail-create')
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


<div class="row mb-4">
        <div class="col">
            <div class="card text-center p-3">
                <h5>{{ $total_meals }}</h5>
                <p>Monthly Total Meals</p>
            </div>
        </div>
        <div class="col">
            <div class="card text-center p-3">
                <h5>{{ $total_lunch }}</h5>
                <p>Monthly Total Lunch</p>
            </div>
        </div>
        <div class="col">
            <div class="card text-center p-3">
                <h5>{{ $total_dinner }}</h5>
                <p>Monthly Total Dinner</p>
            </div>
        </div>
    </div>
                       
                @if ($data->count() > 0)
                    <!--begin: Datatable-->
                   <table class="table" id="">
                       




            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Date</th>
                    <th>Students</th>
                    <th>Total Meals</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
            </thead>
            <tbody>
                @php $serial = ($data->currentPage() - 1) * $data->perPage() + 1; @endphp
                @foreach ($data as $row)
                <tr>
                    <td>{{ $serial++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->meal_date)->format('d/m/Y') }}</td>
                    <td>{{ $row->students }}</td>
                    <td>{{ $row->meals }}</td>
                    <td>{{ $row->total_lunch }}</td>
                    <td>{{ $row->total_dinner }}</td>
                </tr>
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
