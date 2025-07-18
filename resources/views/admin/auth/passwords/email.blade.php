@extends('admin.layouts.guest')

@section('content')
        <!-- ===============>> account start here <<================= -->
        <section class="account d-flex align-items-center justify-content-center min-vh-100">
            <div class="container">
                <div class="account__wrapper">
                    <div class="account__content account__content--style1">
                        <!-- account tittle -->
                        <div class="account__header">
                            <div class="account__header-logo">
                                <img src="{{asset('assets/images/logo/logo-icon.png')}}" alt="logo" />
                            </div> 
                            <h3>Forget Password</h3>
                            <p>No worries, we’ll send you reset instructions.</p>
                        </div>
                        <!-- account form -->
                        <form method="POST" action="{{ route('admin.password.email') }}" class="form needs-validation" novalidate>
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary d-block mt-4">{{ __('Send Password Reset Link') }}</button>
                        </form>

                        <div class="account__switch text-center mt-4">
                            <p>Password Remembered? <a href="{{route('admin.login')}}">Login with Password</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ===============>> account end here <<================= -->
@endsection