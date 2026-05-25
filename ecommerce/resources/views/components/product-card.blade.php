<div class="card product-card border-0 shadow-sm h-100">
    <div class="position-relative">
        <a href="{{ route('product.show', $product->slug) }}">
            @if($product->images->isNotEmpty())
                <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" class="card-img-top" alt="{{ $product->name }}" style="height:200px;object-fit:cover;">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;"><i class="fas fa-image fa-3x text-muted"></i></div>
            @endif
        </a>
        @if($product->discount_price)
            <span class="position-absolute top-0 start-0 m-2 badge bg-danger">SALE</span>
        @endif
        @if($product->is_featured)
            <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark">Featured</span>
        @endif
    </div>
    <div class="card-body d-flex flex-column p-3">
        <div class="small text-muted mb-1">{{ $product->category?->name }}</div>
        <h6 class="card-title fw-semibold mb-1">
            <a href="{{ route('product.show', $product->slug) }}" class="text-dark text-decoration-none">{{ Str::limit($product->name, 50) }}</a>
        </h6>
        <div class="mb-2 text-warning small">
            @for($i=1;$i<=5;$i++)<i class="fa{{ $i<=round($product->rating_avg)?'s':'r' }} fa-star"></i>@endfor
            <span class="text-muted ms-1">({{ $product->rating_count }})</span>
        </div>
        <div class="mt-auto d-flex justify-content-between align-items-center">
            <div>
                @if($product->discount_price)
                    <span class="fw-bold text-primary">${{ number_format($product->discount_price,2) }}</span>
                    <span class="text-muted text-decoration-line-through ms-1 small">${{ number_format($product->price,2) }}</span>
                @else
                    <span class="fw-bold text-primary">${{ number_format($product->price,2) }}</span>
                @endif
            </div>
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-cart-plus me-1"></i>Add
                </button>
            </form>
        </div>
    </div>
</div>
