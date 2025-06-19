<div class="header d-flex justify-content-between align-items-center px-4 py-3 bg-white border-bottom"
    style="height: 90px;">
    {{-- Logo bên trái --}}
    <div class="d-flex align-items-center">
        <img src="{{ asset('images/logoAeriel.png') }}" alt="Logo" style="height: 80px;">
    </div>
    <div class="d-flex align-items-center position-relative" id="userDropdownContainer">
        {{-- Avatar --}}
        <div class="rounded-circle text-white d-flex justify-content-center align-items-center me-2"
             style="width: 40px; height: 40px; font-weight: bold; background-color: #2C3E50; font-size: 16px;">
            {{ strtoupper(substr(session('employee_name', 'U'), 0, 1)) }}
        </div>
        <div class="d-flex align-items-center" style="cursor: pointer;">
            <div>
                <div class="fw-bold text-dark" style="font-size: 14px;">{{ session('employee_name', 'Unknown User') }}</div>
                <div class="text-muted" style="font-size: 12px;">{{ session('employee_role', 'Nhân viên') }}</div>
            </div>
            <i class="fas fa-chevron-down ms-2" style="font-size: 12px; color: #6c757d;" id="dropdownArrow"></i>
        </div>
        <div id="userDropdown" style="
        position: absolute;
        top: 100%;
        right: 0;
        min-width: 150px;
        margin-top: 5px;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 1000;
        display: none;
    ">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="
                    display: flex;
                    align-items: center;
                    padding: 8px 16px;
                    color: #dc3545;
                    text-decoration: none;
                    font-size: 14px;
                    border-radius: 8px;
                    background: none;
                    border: none;
                    width: 100%;
                    text-align: left;
                " onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='white'">
                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                </button>
            </form>
        </div>
    </div>

    <script>
        let dropdownTimeout;

        function showDropdown() {
            clearTimeout(dropdownTimeout);
            const dropdown = document.getElementById('userDropdown');
            const arrow = document.getElementById('dropdownArrow');

            dropdown.style.display = 'block';
            if (arrow) {
                arrow.style.transform = 'rotate(180deg)';
                arrow.style.transition = 'transform 0.2s ease';
            }
        }

        function hideDropdown() {
            dropdownTimeout = setTimeout(function() {
                const dropdown = document.getElementById('userDropdown');
                const arrow = document.getElementById('dropdownArrow');
                dropdown.style.display = 'none';
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }, 300);
        }
        function keepDropdown() {
            clearTimeout(dropdownTimeout);
        }
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('userDropdownContainer');
            const dropdown = document.getElementById('userDropdown');

            if (container && dropdown) {
                container.addEventListener('mouseenter', showDropdown);
                container.addEventListener('mouseleave', hideDropdown);
                dropdown.addEventListener('mouseenter', keepDropdown);
                dropdown.addEventListener('mouseleave', hideDropdown);
            }
        });
    </script>

</div>
