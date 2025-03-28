@extends('guest.layouts.app')

@section('content')
    <div class="login-page py-4" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="form-box shadow">
                <div class="form-tab">
                    <h3 class="text-center mb-4">Đăng Ký</h3>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="register-name">Nhập tên của bạn *</label>
                            <input type="text" class="form-control" id="register-name" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="register-email">Địa chỉ email của bạn *</label>
                            <input type="text" class="form-control" id="register-email" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="register-password">Mật khẩu *</label>
                            <input type="password" class="form-control" id="register-password" name="password"
                                value="{{ old('password') }}">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="register-password">Xác nhận mật khẩu *</label>
                            <input type="password" class="form-control" id="register-password" name="password_confirmation">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-outline-primary-2">
                                <span>ĐĂNG KÝ</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                    <div class="form-choice">
                        <p class="text-center">hoặc đăng ký bằng</p>
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-login btn-g">
                                    <i class="icon-google"></i>
                                    Đăng ký với Google
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-login btn-f">
                                    <i class="icon-facebook-f"></i>
                                    Đăng ký với Facebook
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
