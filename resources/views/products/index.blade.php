@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
            <div>
                <h1 class="fw-bold text-dark mb-1" style="font-size: 2.6rem;">Products</h1>
                <p class="text-muted mb-0" style="font-size: 1rem;">A clean and simple way to manage your catalog</p>
            </div>

            <a href="{{ route('products.create') }}"
               class="btn btn-dark btn-lg mt-3 mt-md-0 px-4 rounded-3 shadow-sm"
               style="font-weight: 500;">
                <i class="bi bi-plus-circle me-2"></i> New Product
            </a>
        </div>

        <!-- Flash message -->
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Products -->
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm product-card rounded-4">

                        <!-- Image -->
                        @if($product->image)
                            <img src="{{ route('products.image', basename($product->image)) }}"
                                 class="card-img-top rounded-top"
                                 alt="{{ $product->name }}"
                                 style="height: 210px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-top"
                                 style="height: 210px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <!-- Stock badge -->
                        <span class="badge position-absolute top-0 end-0 m-2
                            {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}
                            px-3 py-2 rounded-pill shadow-sm">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>

                        <div class="card-body d-flex flex-column">

                            <h5 class="fw-semibold mb-2">{{ $product->name }}</h5>
                            <p class="text-muted small flex-grow-1 mb-3">
                                {{ Str::limit($product->description, 70) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold text-dark" style="font-size: 1.4rem;">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                                <span class="text-muted small">Stock: {{ $product->stock }}</span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('products.edit', $product) }}"
                                   class="btn btn-outline-dark btn-sm rounded-3 w-50">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="w-50">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-outline-danger btn-sm rounded-3 w-100"
                                            onclick="return confirm('Delete this product?')">
                                        Delete
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
        /* Smooth modern hover */
        .product-card {
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.12) !important;
        }

        /* Image fade */
        .product-card img {
            transition: opacity .3s;
        }
        .product-card:hover img {
            opacity: .92;
        }

        h1, h5 {
            letter-spacing: -0.3px;
        }
    </style>
@endsection
