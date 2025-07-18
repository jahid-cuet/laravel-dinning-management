@extends('admin.layouts.master')

@section('title')
    {{$page_title}}
@endsection

@section('container')
        <div class="row">
            <div class="col-lg-12">
                <div class="trk-card">
                    <div class="trk-card__header d-flex justify-content-between">
                        <div class="trk-card__title">
                            <h5>{{$info->title}}</h5>
                        </div>
                        <div class="float-right">
                            @can('dinning-student-update')
                                <a href="{{ route($info->first_button_route,$id)}}" class="btn btn-primary">
                                    <i class="flaticon2-add"></i>
                                    {{$info->first_button_title}}
                                </a>
                            @endcan
                            <a href="{{ route($info->second_button_route) }}" class="btn btn-warning">
                                <i class="flaticon2-add"></i>
                                {{ $info->second_button_title }}
                            </a>
                        </div>
                    </div>
                    <div class="trk-card__body">
                        <div class="trk-card__body-text">
                            <ul class="crud-view mt-4">
                                <li class="crud-view__item">
    <span class="crud-view__item-title">Avatar:</span>
    <span class="crud-view__item-content">
    <div class="trk-avatar d-flex flex-wrap align-items-center">
        <div class="trk-avatar__item me-3">
            
                    <img style="height:100px;"
                        @if ($data->avatar) 
                            src="{{ asset($data->avatar) }}"
                        @else                
                            src="{{ asset(avatarUrl()) }}" 
                        @endif
                        alt="#" data-bs-original-title="" title="">
        </div>
    </div>
    </span>
</li>
<li class="crud-view__item">
    <span class="crud-view__item-title">Student Id:</span>
    <span class="crud-view__item-content">{{ $data->student_id}}</span>
</li>
<li class="crud-view__item">
    <span class="crud-view__item-title">Name:</span>
    <span class="crud-view__item-content">{{ $data->name}}</span>
</li>
<li class="crud-view__item">
    <span class="crud-view__item-title">Txid:</span>
    <span class="crud-view__item-content">{{ $data->txid}}</span>
</li>
<li class="crud-view__item">
    <span class="crud-view__item-title">Total Meal:</span>
    <span class="crud-view__item-content">{{ $data->total_meals}}</span>
</li>
<li class="crud-view__item">
    <span class="crud-view__item-title">From:</span>
    <span class="crud-view__item-content">{{ date('d M Y',strtotime($data->from))}}</span>
</li>

<li class="crud-view__item">
    <span class="crud-view__item-title">To:</span>
    <span class="crud-view__item-content">{{ date('d M Y',strtotime($data->to))}}</span>
</li>

<li class="crud-view__item">
    <span class="crud-view__item-title">Paid Status:</span>
    <span class="crud-view__item-content">
                    {{ $data->paid_status}}            </span>
</li><li class="crud-view__item">
    <span class="crud-view__item-title">User:</span>
    <span class="crud-view__item-content">
                                        
                {{$data->user?->name}}            
                
            </span>
</li><li class="crud-view__item">
    <span class="crud-view__item-title">Dinning Month:</span>
    <span class="crud-view__item-content">
                                        
                {{$data->dinningMonth?->title}}            
                
            </span>
</li><li class="crud-view__item">
    <span class="crud-view__item-title">Department:</span>
    <span class="crud-view__item-content">
                                        
                {{$data->department?->name}}            
                
            </span>
</li><li class="crud-view__item">
    <span class="crud-view__item-title">Student Session:</span>
    <span class="crud-view__item-content">
                                        
                {{$data->studentSession?->name}}            
                
            </span>
</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
