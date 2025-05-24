<form class="form"
      action="{{ route('frontend.shopping-cart.create-or-update', [$product->slug, $variantProduct->id]) }}"
      method="POST" data-id="{{ $variantProduct->id }}">
    @csrf
    <input type="hidden" id="productImage-{{ $variantProduct->id }}"
           value="{{ url($variantProduct->image) }}">
    <input type="hidden" id="productTitle-{{ $variantProduct->id }}"
           value="{{ generateVariantProductData($product, $variantProduct->id, $selectedOptionsValue)['name'] }}">
    <input type="hidden" id="productType"
           value="variation">
    <input type="hidden" id="selectedOptions"
           value="{{ json_encode($selectedOptions) }}">
    <input type="hidden" id="selectedOptionsValue"
           value="{{ json_encode($selectedOptionsValue) }}">

    <div class="align-items-center d-flex">
        <h5>{{ __('catalog::frontend.products.quantity') }}</h5>
        <div class="quantity">
            <div class="buttons-added">
                <button class="sign plus"><i class="fa fa-chevron-up"></i></button>
                <input type="text"
                       id="prodQuantity"
                       value="{{ getCartItemById('var-' . $variantProduct->id) ? getCartItemById('var-' . $variantProduct->id)->quantity : '1' }}"
                       title="Qty" class="input-text qty text" size="1">
                <button class="sign minus"><i class="fa fa-chevron-down"></i></button>
            </div>
        </div>

        <button id="btnAddToCart" class="btn btn-them add-cart-btn"
                type="button"><i class="ti-shopping-cart"></i>
            {{ __('catalog::frontend.products.add_to_cart') }}
        </button>

        <div id="loaderDiv">
            <div class="my-loader"></div>
        </div>
    </div>
</form>
