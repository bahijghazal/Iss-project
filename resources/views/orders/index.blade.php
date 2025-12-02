@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-dark mb-2">My Orders</h1>
                <p class="text-muted">Track and manage your order history</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-cart-plus me-2"></i>Place New Order
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($orders->count() > 0)
            <!-- Orders List -->
            <div class="row g-3">
                @foreach($orders as $order)
                    <div class="col-12">
                        <div class="card shadow-sm border-0 order-card">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <!-- Product Image -->
                                    <div class="col-md-2 col-3 mb-3 mb-md-0">
                                        @if($order->product->image)
                                            <img src="{{ asset('storage/' . $order->product->image) }}"
                                                 alt="{{ $order->product->name }}"
                                                 class="img-fluid rounded"
                                                 style="height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                                <i class="bi bi-box-seam text-muted" style="font-size: 2rem;"></i>
                                            </div>
                                        @endif
                                    </div>


                                    <!-- Order Details -->
                                    <div class="col-md-4 col-9 mb-3 mb-md-0">
                                        <h5 class="fw-bold text-dark mb-2">{{ $order->product->name }}</h5>
                                        <div class="d-flex gap-3 text-muted small">
                                            <span><i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('M d, Y') }}</span>
                                            <span><i class="bi bi-clock me-1"></i>{{ $order->created_at->format('h:i A') }}</span>
                                        </div>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-md-2 col-6 mb-3 mb-md-0 text-center">
                                        <div class="text-muted small mb-1">Quantity</div>
                                        <div class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2">
                                            {{ $order->quantity }} {{ Str::plural('item', $order->quantity) }}
                                        </div>
                                    </div>

                                    <!-- Total Price -->
                                    <div class="col-md-2 col-6 mb-3 mb-md-0 text-center">
                                        <div class="text-muted small mb-1">Total Price</div>
                                        <div class="h4 text-success fw-bold mb-0">${{ number_format($order->total_price, 2) }}</div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="col-md-2 col-12 text-md-end">
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="bi bi-check-circle me-1"></i>Completed
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="card shadow-sm border-0 text-center py-5">
                <div class="card-body">
                    <i class="bi bi-cart-x text-muted mb-3" style="font-size: 4rem;"></i>
                    <h3 class="text-muted mb-3">No Orders Yet</h3>
                    <p class="text-muted mb-4">You haven't placed any orders. Start shopping now!</p>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus me-2"></i>Place Your First Order
                    </a>
                </div>
            </div>
        @endif

        <!-- Order Summary Stats -->
        @if($orders->count() > 0)
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-primary bg-opacity-10 text-center p-4">
                        <i class="bi bi-bag-check text-primary mb-2" style="font-size: 2rem;"></i>
                        <h3 class="fw-bold text-primary mb-0">{{ $orders->total() }}</h3>
                        <small class="text-muted">Total Orders</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-success bg-opacity-10 text-center p-4">
                        <i class="bi bi-currency-dollar text-success mb-2" style="font-size: 2rem;"></i>
                        <h3 class="fw-bold text-success mb-0">${{ number_format($orders->sum('total_price'), 2) }}</h3>
                        <small class="text-muted">Total Spent</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-info bg-opacity-10 text-center p-4">
                        <i class="bi bi-box text-info mb-2" style="font-size: 2rem;"></i>
                        <h3 class="fw-bold text-info mb-0">{{ $orders->sum('quantity') }}</h3>
                        <small class="text-muted">Items Ordered</small>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .order-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .display-4 {
            letter-spacing: -0.5px;
        }

        .badge {
            font-weight: 500;
        }
    </style>
@endsection
