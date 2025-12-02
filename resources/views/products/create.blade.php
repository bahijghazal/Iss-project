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
                    <h1 class="display-5 fw-bold text-dark mb-2">Add New Product</h1>
                    <p class="text-muted">Fill in the details below to add a product to your catalog</p>
                </div>

                <!-- Form Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Product Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    Product Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control form-control-lg @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"
                                       placeholder="Enter product name">
                                @error('name')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold text-dark">
                                    Description <span class="text-danger">*</span>
                                </label>
                                <textarea name="description"
                                          id="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Describe your product...">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                                <small class="text-muted">Provide a detailed description to help customers understand your product</small>
                            </div>

                            <!-- Price and Stock Row -->
                            <div class="row">
                                <!-- Price -->
                                <div class="col-md-6 mb-4">
                                    <label for="price" class="form-label fw-semibold text-dark">
                                        Price <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-currency-dollar"></i>
                                    </span>
                                        <input type="number"
                                               step="0.01"
                                               name="price"
                                               id="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price') }}"
                                               placeholder="0.00">
                                        @error('price')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Stock -->
                                <div class="col-md-6 mb-4">
                                    <label for="stock" class="form-label fw-semibold text-dark">
                                        Stock Quantity <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-boxes"></i>
                                    </span>
                                        <input type="number"
                                               name="stock"
                                               id="stock"
                                               class="form-control @error('stock') is-invalid @enderror"
                                               value="{{ old('stock') }}"
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
                                <label for="image" class="form-label fw-semibold text-dark">Product Image</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                                <small class="text-muted">PNG, JPG, JPEG, GIF, or SVG (MAX. 2MB)</small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 pt-3">
                                <button type="submit" class="btn btn-primary btn-lg px-4 flex-grow-1">
                                    <i class="bi bi-check-circle me-2"></i>Save Product
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Text -->
                <div class="alert alert-info border-0 mt-4" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Tip:</strong> Make sure to provide clear and accurate product information to improve customer experience and reduce returns.
                </div>
            </div>
        </div>
    </div>
@endsection
