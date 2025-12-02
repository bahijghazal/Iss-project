@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-dark mb-2">Product Catalog</h1>
                <p class="text-muted">Manage your entire product inventory</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Add New Product
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Product Grid -->
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm border-0 product-card position-relative">
                        <!-- Product Image -->
                        @if($product->image)
                            <img src="{{ route('products.image', basename($product->image)) }}"
                                 class="card-img-top"
                                 alt="{{ $product->name }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <!-- Stock Badge -->
                        @if($product->stock > 0)
                            <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
                        @else
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">Out of Stock</span>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $product->name }}</h5>
                            <p class="card-text text-muted small mb-3 flex-grow-1">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h4 text-primary fw-bold mb-0">${{ number_format($product->price, 2) }}</span>
                                <span class="text-muted small">Stock: {{ $product->stock }}</span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('products.edit', $product) }}"
                                   class="btn btn-outline-primary btn-sm flex-grow-1">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>

                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-outline-danger btn-sm w-100"
                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    </div>

    <style>
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        }

        .card-img-top {
            transition: all 0.3s ease;
        }

        .product-card:hover .card-img-top {
            opacity: 0.9;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .display-4 {
            letter-spacing: -0.5px;
        }
    </style>
@endsection
