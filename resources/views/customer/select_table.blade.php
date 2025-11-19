@extends('layouts.customer')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-12 col-md-6 col-lg-4">
            
            <!-- Card Form -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    
                    <!-- Icon & Title -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-table fs-1 text-primary"></i>
                        </div>
                        <h1 class="h3 fw-bold mb-2">Selamat Datang!</h1>
                        <p class="text-muted">Silakan pilih nomor meja Anda untuk memulai pemesanan.</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('customer.select.table.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="table_number" class="form-label fw-semibold">
                                <i class="bi bi-list-ol me-1"></i>Pilih Meja Anda
                            </label>
                            <select 
                                name="table_number" 
                                id="table_number" 
                                class="form-select form-select-lg @error('table_number') is-invalid @enderror"
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
                            
                            @error('table_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                            <i class="bi bi-arrow-right-circle me-2"></i>Mulai Memesan
                        </button>
                    </form>

                </div>
            </div>

            <!-- Link Login Admin -->
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-muted text-decoration-none small">
                    <i class="bi bi-person-lock me-1"></i>Login sebagai Staf/Admin?
                </a>
            </div>
            
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 16px;
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
</style>
@endsection