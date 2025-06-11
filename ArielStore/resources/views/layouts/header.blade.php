<!-- Header -->
<div class="header d-flex justify-content-between align-items-center p-4 bg-light shadow-sm" style="height: 80px;">
    {{-- Logo bên trái --}}
    <div class="d-flex align-items-center">
        <img src="{{ asset('images/logoAeriel.png') }}" alt="Logo" style="height: 50px;">
    </div>

    {{-- Thông tin người dùng bên phải --}}
    <div class="d-flex align-items-center gap-3">
        {{-- Avatar (chữ cái đầu) --}}
        <div class="rounded-circle text-white d-flex justify-content-center align-items-center" 
             style="width: 40px; height: 40px; font-weight: bold; background-color: #2C3E50"
             
             >
            A
        </div>

        <div class="text-end">
            <div class="fw-bold">Quang Anh</div>
            <div class="text-muted" style="font-size: small;">Quản trị viên</div>
        </div>
    </div>
</div>
