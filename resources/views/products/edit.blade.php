@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="mb-4">
                    <a href="{{ route('products.index') }}" class="text-decoration-none text-muted d-inline-flex align-items-center mb-3">
                        <i class="bi bi-arrow-left me-2"></i>Back to Products
                    </a>
                    <h1 class="display-5 fw-bold text-dark mb-2">Edit Product</h1>
                    <p class="text-muted">Update the product information below</p>
                </div>

                <!-- Form Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Product Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold text-dark">Product Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control form-control-lg @error('name') is-invalid @enderror"
                                       value="{{ old('name', $product->name) }}"
                                       placeholder="Enter product name">
                                @error('name')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold text-dark">Description <span class="text-danger">*</span></label>
                                <textarea name="description"
                                          id="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Describe your product...">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Price and Stock -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="price" class="form-label fw-semibold text-dark">Price <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light"><i class="bi bi-currency-dollar"></i></span>
                                        <input type="number"
                                               step="0.01"
                                               name="price"
                                               id="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price', $product->price) }}"
                                               placeholder="0.00">
                                        @error('price')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="stock" class="form-label fw-semibold text-dark">Stock Quantity <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light"><i class="bi bi-boxes"></i></span>
                                        <input type="number"
                                               name="stock"
                                               id="stock"
                                               class="form-control @error('stock') is-invalid @enderror"
                                               value="{{ old('stock', $product->stock) }}"
                                               placeholder="0">
                                        @error('stock')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Product Image</label>
                                <div class="border border-2 border-dashed rounded p-4 text-center bg-light position-relative">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid mb-2" style="max-height: 150px;">
                                    @else
                                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    @endif
                                    <p class="text-muted mb-2">Click to upload or drag and drop</p>
                                    <small class="text-muted">PNG, JPG or WEBP (MAX. 2MB)</small>
                                    <input type="file" name="image" class="form-control mt-2 @error('image') is-invalid @enderror">
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 pt-3">
                                <button type="submit" class="btn btn-primary btn-lg px-4 flex-grow-1">
                                    <i class="bi bi-save me-2"></i>Update Product
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg px-4">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .form-control:focus, .form-control-lg:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            }

            .input-group-text { border-color: #dee2e6; }

            .card { transition: box-shadow 0.3s ease; }

            .btn-primary {
                background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
                border: none;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            }

            .btn-danger:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            }

            .border-dashed {
                border-style: dashed !important;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .border-dashed:hover {
                border-color: #0d6efd !important;
                background-color: #f8f9fa !important;
            }
        </style>
@endsection
