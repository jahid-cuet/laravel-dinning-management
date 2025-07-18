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
                            enctype="multipart/form-data" id="refundForm">
                            @csrf
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Lunch</th>
                                        <th>Dinner</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($meals as $meal)
                                        <tr>
                                            <td>
                                                @if ($meal->lunch)
                                                    <input type="checkbox" class="meal-checkbox" name="meals[{{ $meal->id }}][lunch]"
                                                        value="1">
                                                @else
                                                    <span class="text-muted">No Lunch</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($meal->dinner)
                                                    <input type="checkbox" class="meal-checkbox" name="meals[{{ $meal->id }}][dinner]"
                                                        value="1">
                                                @else
                                                    <span class="text-muted">No Dinner</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($meal->meal_date)->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>


                            <button type="submit" class="btn btn-primary">Request for Refund</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('refundForm');

            form.addEventListener('submit', function(e) {
                const checkboxes = form.querySelectorAll('.meal-checkbox');
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);

                if (!anyChecked) {
                    e.preventDefault();
                    alert('⚠️ Please select at least one meal (Lunch or Dinner).');
                }
            });
        });
    </script>

    {{-- SCRIPT --}}
@endsection
