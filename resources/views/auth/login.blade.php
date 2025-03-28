@extends('guest.layouts.app')

@section('content')
    <div class="login-page py-4" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="form-box shadow">
                <div class="form-tab">
                    <h3 class="text-center mb-4">Đăng Nhập</h3>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="singin-email">Email *</label>
                            <input type="text" class="form-control" id="singin-email" name="email">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="singin-password">Mật khẩu *</label>
                            <input type="password" class="form-control" id="singin-password" name="password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-outline-primary">
                                <span>ĐĂNG NHẬP</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="signin-remember" name="remember">
                                <label class="custom-control-label" for="signin-remember">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>

                            <a href="#" class="forgot-link">Quên mật khẩu?</a>
                        </div>
                    </form>
                    <div class="form-choice">
                        <p class="text-center">hoặc đăng nhập bằng</p>
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-login btn-g">
                                    <i class="icon-google"></i>
                                    Đăng nhập với Google
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-login btn-f">
                                    <i class="icon-facebook-f"></i>
                                    Đăng nhập với Facebook
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
