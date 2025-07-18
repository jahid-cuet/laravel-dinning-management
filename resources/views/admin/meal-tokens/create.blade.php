{{-- Extends layout --}}
@extends('admin.layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">


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


                    <h3 class="text-center">Scan Token</h3>
                    <div class="text-center my-3">
                        <strong>Now:</strong> {{ $now }} (It's {{ $meal_time }})
                    </div>



                    {{-- Card Header End --}}

                    {{-- Card Body Start --}}
                    <div class="trk-card__body">
                        {{-- <form class="form" action="{{ route($info->form_route) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="student_id">Student ID <span>&#x002A;</span>
                                        </label>
                                        <input type="text" value="{{ old('student_id') }}"
                                            class="form-control @error('student_id') is-invalid @enderror" id="student_id"
                                            name="student_id" placeholder="Enter Student ID" required>
                                        @error('student_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary mt-4">Confirm</button>
                                </div>
                            </div>
                        </form> --}}

    <form id="validateTokenForm">
    @csrf
    <div class="row g-4">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="student_id">Student ID <span>*</span></label>
                <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter Student ID" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10">
            <button type="submit" class="btn btn-primary mt-4">Confirm</button>
        </div>
    </div>
</form>






<div id="validationResult" class="mt-4"></div>

                    </div>
                    {{-- Card Body End --}}
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#validateTokenForm').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: "{{ route($info->form_route)}}",
        method: 'POST',
        data: $(this).serialize(),
success: function(response){
    if(response.status === 'success'){
        $('#validationResult').html(`
            <div class="text-center p-3">
                <h4 class="text-success">✅ Valid Token</h4>
            </div>

            <ul class="list-group">
                <li class="list-group-item">Student Name: ${response.student}</li>
                <li class="list-group-item">Student ID: ${response.student_id}</li>
                <li class="list-group-item">Token Number: TKN${response.meal_id}</li>
                <li class="list-group-item">Dining Date: ${response.meal_date}</li>
                <li class="list-group-item">Meal Time: ${response.mealTime}</li>
            </ul>
        `);
    }else{
        $('#validationResult').html(`<div class="alert alert-danger">${response.message}</div>`);
    }
},
        error: function(xhr){
            $('#validationResult').html(`<div class="alert alert-danger">Unexpected error.</div>`);
        }
    });
});
</script>
@endsection

@section('css')
    @parent
@endsection

@section('js')
    @parent

    {{-- SCRIPT --}}
@endsection
