<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #fafafa;
            height: 100vh; 
            margin: 0;
            padding: 0;
        }

        .login-container {
            height: 100vh;
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }

        .login-card {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 450px;
            margin: 0; 
        }

        .login-header {
            background: white;
            border-bottom: 1px solid #f1f1f1;
            border-radius: 15px 15px 0 0;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
        }

        .form-label {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #666;
        }

        .login-title {
            color: #2c3e50;
            font-weight: 600;
        }

        .login-subtitle {
            color: #666;
            font-size: 1.05rem;
        }

        .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
        }

        .btn-primary:hover {
            background-color: #1e2b37;
            border-color: #1e2b37;
        }


        /* Responsive cho mobile */
        @media (max-width: 768px) {
            .login-container {
                padding: 20px;
            }
            
            .login-card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container">
        <div class="card login-card">
            <div class="card-header login-header d-flex align-items-center justify-content-center py-4">
                <img src="{{ asset('/images/logoAeriel.png') }}" alt="" height="70" class="object-fit-cover">
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h4 class="login-title mb-2">Chào mừng trở lại!</h4>
                    <p class="login-subtitle mb-0">Vui lòng đăng nhập để tiếp tục</p>
                </div>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label text-sm" for="floatingInput">Email:</label>
                        <input name="email" type="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="floatingInput"
                            placeholder="Nhập email của bạn" tabindex="1"
                            value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="floatingPassword">Mật khẩu:</label>
                        <input name="password" type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="floatingPassword"
                            placeholder="Nhập mật khẩu của bạn" tabindex="2">
                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 fw-medium" tabindex="3">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>