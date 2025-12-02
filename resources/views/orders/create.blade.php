@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-dark mb-2">Product Catalog</h1>
                <p class="text-muted">Select products to add to your cart and place an order</p>
            </div>
            <div class="col-md-4 text-md-end">
                <button class="btn btn-success btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="bi bi-cart me-2"></i>View Cart (<span id="cartCount">0</span>)
                </button>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm border-0 product-card position-relative">
                        <!-- Product Image -->
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
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
                            <p class="card-text text-muted small mb-3 flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 text-primary fw-bold mb-0">${{ number_format($product->price, 2) }}</span>
                                <span class="text-muted small">Stock: {{ $product->stock }}</span>
                            </div>
                            <button class="btn btn-success add-to-cart-btn" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}" {{ $product->stock==0?'disabled':'' }}>
                                <i class="bi bi-cart-plus me-1"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Cart Modal -->
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('orders.store') }}" method="POST" id="placeOrderForm">
                    @csrf
                    <input type="hidden" name="cart_data" id="cartData">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered" id="cartTable">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                <h5>Total: $<span id="cartTotal">0.00</span></h5>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="placeOrderBtn" disabled>
                                <i class="bi bi-cart-check me-1"></i>Place Order
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function updateCart() {
            const tbody = document.querySelector('#cartTable tbody');
            tbody.innerHTML = '';
            let total = 0;
            cart.forEach((item,index) => {
                const rowTotal = item.price * item.quantity;
                total += rowTotal;

                tbody.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td><input type="number" min="1" max="${item.stock}" value="${item.quantity}" class="form-control form-control-sm qty-input" data-index="${index}"></td>
                    <td>$${rowTotal.toFixed(2)}</td>
                    <td><button class="btn btn-danger btn-sm remove-item" data-index="${index}"><i class="bi bi-trash"></i></button></td>
                </tr>
            `;
            });

            document.getElementById('cartTotal').textContent = total.toFixed(2);
            document.getElementById('cartCount').textContent = cart.length;
            document.getElementById('cartData').value = JSON.stringify(cart);
            document.getElementById('placeOrderBtn').disabled = cart.length===0;

            // Qty input change
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', function(){
                    const idx = this.dataset.index;
                    let val = parseInt(this.value) || 1;
                    if(val > cart[idx].stock) val = cart[idx].stock;
                    cart[idx].quantity = val;
                    updateCart();
                });
            });

            // Remove button
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function(){
                    const idx = this.dataset.index;
                    cart.splice(idx,1);
                    updateCart();
                });
            });
        }

        document.querySelectorAll('.add-to-cart-btn').forEach(btn=>{
            btn.addEventListener('click', function(){
                const id = this.dataset.id;
                const name = this.dataset.name;
                const price = parseFloat(this.dataset.price);
                const stock = parseInt(this.dataset.stock);

                const existing = cart.find(item=>item.id==id);
                if(existing){
                    if(existing.quantity<stock) existing.quantity +=1;
                } else {
                    cart.push({id,name,price,quantity:1,stock});
                }

                updateCart();
            });
        });
    </script>

    <style>
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.15)!important;
        }
        .card-img-top {
            transition: all 0.3s ease;
        }
        .product-card:hover .card-img-top {
            opacity: 0.9;
        }
    </style>
@endsection
