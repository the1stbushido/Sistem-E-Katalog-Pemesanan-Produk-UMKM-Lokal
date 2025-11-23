@extends('layouts.customer')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center position-relative overflow-hidden" style="min-height: calc(100vh - 70px); padding-top: 2rem; padding-bottom: 2rem;">
    
    <!-- Background Decoration -->
    <div class="bg-decoration"></div>
    <div class="bg-decoration-2"></div>
    
    <div class="row justify-content-center w-100 position-relative" style="z-index: 1;">
        <div class="col-12 col-md-8 col-lg-5 col-xl-4">
            
            <!-- Main Card -->
            <div class="welcome-card">
                <div class="card-inner">
                    
                    <!-- Animated Icon -->
                    <div class="text-center mb-4">
                        <div class="icon-wrapper mb-3">
                            <div class="icon-circle">
                                <i class="bi bi-table fs-1"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <h1 class="welcome-title mb-2">Selamat Datang!</h1>
                        <p class="welcome-subtitle">Silakan pilih nomor meja Anda untuk memulai pemesanan.</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('customer.select.table.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group-custom mb-4">
                            <label for="table_number" class="form-label-custom">
                                <i class="bi bi-list-ol me-2"></i>Pilih Meja Anda
                            </label>
                            <div class="select-wrapper">
                                <select 
                                    name="table_number" 
                                    id="table_number" 
                                    class="form-select-custom @error('table_number') is-invalid @enderror"
                                    required>
                                    
                                    <option value="" disabled selected>-- Pilih Nomor Meja --</option>
                                    
                                    @forelse ($tables as $table)
                                        <option value="{{ $table->table_number }}">
                                            Meja {{ $table->table_number }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Maaf, tidak ada meja tersedia</option>
                                    @endforelse

                                </select>
                                <i class="bi bi-chevron-down select-arrow"></i>
                            </div>
                            
                            @error('table_number')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Quick Table Selection -->
                        <div class="quick-select-section mb-4">
                            <div class="divider-text">
                                <span>atau pilih cepat</span>
                            </div>
                            
                            <div class="table-grid" id="tableGrid">
                                @forelse ($tables as $table)
                                    <div class="table-card" data-table="{{ $table->table_number }}" onclick="
                                        var tableNum = '{{ $table->table_number }}';
                                        document.getElementById('table_number').value = tableNum;
                                        document.querySelectorAll('.table-card').forEach(function(c) { c.classList.remove('selected'); });
                                        this.classList.add('selected');
                                        console.log('Selected table:', tableNum);
                                    ">
                                        <div class="table-icon">
                                            <i class="bi bi-table"></i>
                                        </div>
                                        <div class="table-number">{{ $table->table_number }}</div>
                                    </div>
                                @empty
                                    <p class="text-muted text-center w-100 mb-0">Tidak ada meja tersedia</p>
                                @endforelse
                            </div>
                        </div>

                        <button type="submit" class="btn-submit w-100">
                            <span class="btn-text">
                                <i class="bi bi-arrow-right-circle me-2"></i>Mulai Memesan
                            </span>
                            <span class="btn-shine"></span>
                        </button>
                    </form>

                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="admin-link">
                    <i class="bi bi-person-lock me-2"></i>Login sebagai Staf/Admin?
                </a>
            </div>
            
        </div>
    </div>
</div>

<style>
    /* Reset & Base */
    body {
        overflow-x: hidden;
    }
    
    .container-fluid {
        margin-top: 0;
        padding-top: 2rem;
    }
    
    /* Background Decorations */
    .bg-decoration,
    .bg-decoration-2 {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
        pointer-events: none;
    }
    
    .bg-decoration {
        width: 500px;
        height: 500px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        top: -200px;
        right: -100px;
        animation: float 20s ease-in-out infinite;
    }
    
    .bg-decoration-2 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        bottom: -150px;
        left: -100px;
        animation: float 15s ease-in-out infinite reverse;
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
    }
    
    /* Welcome Card */
    .welcome-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.1),
            0 0 0 1px rgba(255, 255, 255, 0.5);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    
    .welcome-card:hover {
        transform: translateY(-8px);
        box-shadow: 
            0 30px 80px rgba(102, 126, 234, 0.2),
            0 0 0 1px rgba(255, 255, 255, 0.8);
    }
    
    .card-inner {
        padding: 3rem 2.5rem;
    }
    
    /* Icon Animation */
    .icon-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .icon-circle {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        position: relative;
        z-index: 2;
        animation: iconBounce 2s ease-in-out infinite;
    }
    
    .icon-pulse {
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        opacity: 0.4;
        animation: pulse 2s ease-out infinite;
    }
    
    @keyframes iconBounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.4;
        }
        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }
    
    /* Typography */
    .welcome-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }
    
    .welcome-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    /* Form Elements */
    .form-group-custom {
        margin-bottom: 1.5rem;
    }
    
    .form-label-custom {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        display: block;
        font-size: 0.95rem;
    }
    
    .select-wrapper {
        position: relative;
    }
    
    .form-select-custom {
        width: 100%;
        padding: 1rem 3rem 1rem 1.25rem;
        font-size: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        background: white;
        color: #2d3748;
        transition: all 0.3s ease;
        appearance: none;
        cursor: pointer;
        font-weight: 500;
    }
    
    .form-select-custom:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }
    
    .form-select-custom:hover {
        border-color: #cbd5e0;
    }
    
    .select-arrow {
        position: absolute;
        right: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #667eea;
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }
    
    .form-select-custom:focus ~ .select-arrow {
        transform: translateY(-50%) rotate(180deg);
    }
    
    .form-select-custom.is-invalid {
        border-color: #e53e3e;
    }
    
    .invalid-feedback {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    /* Submit Button */
    .btn-submit {
        position: relative;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 700;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 16px;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }
    
    .btn-submit:active {
        transform: translateY(-1px);
    }
    
    .btn-text {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-shine {
        position: absolute;
        top: -50%;
        left: -100%;
        width: 100%;
        height: 200%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.3),
            transparent
        );
        transform: skewX(-20deg);
        animation: shine 3s infinite;
    }
    
    @keyframes shine {
        0% { left: -100%; }
        50%, 100% { left: 200%; }
    }
    
    /* Admin Link */
    .admin-link {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        color: #6c757d;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    
    .admin-link:hover {
        background: white;
        color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.15);
    }
    
    /* Quick Table Selection */
    .quick-select-section {
        margin-top: 2rem;
    }
    
    .divider-text {
        position: relative;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .divider-text::before,
    .divider-text::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 40%;
        height: 1px;
        background: linear-gradient(to right, transparent, #e2e8f0, transparent);
    }
    
    .divider-text::before {
        left: 0;
    }
    
    .divider-text::after {
        right: 0;
    }
    
    .divider-text span {
        background: white;
        padding: 0 1rem;
        color: #94a3b8;
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 0.75rem;
        max-height: 250px;
        overflow-y: auto;
        padding: 0.5rem;
        margin: -0.5rem;
    }
    
    .table-grid::-webkit-scrollbar {
        width: 6px;
    }
    
    .table-grid::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    .table-grid::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }
    
    .table-grid::-webkit-scrollbar-thumb:hover {
        background: #667eea;
    }
    
    .table-card {
        position: relative;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        overflow: hidden;
    }
    
    .table-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .table-card:hover {
        transform: translateY(-4px);
        border-color: #667eea;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
    }
    
    .table-card:hover::before {
        opacity: 0.05;
    }
    
    .table-card.selected {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    
    .table-card.selected .table-icon,
    .table-card.selected .table-number {
        color: white;
    }
    
    .table-card:active {
        transform: scale(0.98);
    }
    
    .table-icon {
        position: relative;
        z-index: 1;
        font-size: 1.5rem;
        color: #667eea;
        transition: all 0.3s ease;
    }
    
    .table-number {
        position: relative;
        z-index: 1;
        font-weight: 700;
        font-size: 0.95rem;
        color: #2d3748;
        transition: all 0.3s ease;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .card-inner {
            padding: 2rem 1.5rem;
        }
        
        .welcome-title {
            font-size: 1.75rem;
        }
        
        .icon-circle {
            width: 80px;
            height: 80px;
        }
        
        .icon-pulse {
            width: 80px;
            height: 80px;
        }
        
        .bg-decoration,
        .bg-decoration-2 {
            opacity: 0.05;
        }
        
        .table-grid {
            grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
            gap: 0.6rem;
        }
    }
    
    @media (max-width: 576px) {
        .card-inner {
            padding: 1.5rem 1.25rem;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .welcome-subtitle {
            font-size: 0.875rem;
        }
        
        .table-grid {
            grid-template-columns: repeat(auto-fill, minmax(65px, 1fr));
            gap: 0.5rem;
            max-height: 200px;
        }
        
        .table-card {
            padding: 0.75rem 0.5rem;
        }
        
        .table-icon {
            font-size: 1.25rem;
        }
        
        .table-number {
            font-size: 0.85rem;
        }
    }
</style>
@endsection