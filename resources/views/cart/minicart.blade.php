@if (Session::has('Cart') != null)
    <ul>
        @foreach(Session::get('Cart')->products as $item)
            <li>
                <div class="cart-img">
                    <a href="/products/{{$item['productInfo']->Slug}}"><img src="{{asset('images/product/'.$item['productInfo']->Color)}}" alt=""/></a>
                </div>
                <div class="cart-title">
                    <h4><a href="/products/{{$item['productInfo']->Slug}}">{{$item['productInfo']->VariantName}}</a></h4>
                    <span> {{number_format($item['productInfo']->ProductPrice + ($item['productInfo']->ProductPrice * $item['productInfo']->VariantPrice))}} × {{$item['quantity']}} </span>
                </div>
                <div class="cart-delete">
                    <a style="display: block; cursor: pointer;" data-id="{{$item['productInfo']->ProductId}}" data-variant="{{$item['productInfo']->VariantId}}" data-slug="{{$item['productInfo']->Slug}}" slug="{{$item['productInfo']->Slug}}" class="btn-delete-item-cart">x</a>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="cart-total">
        <h4>Thành tiền: <span>{{number_format(Session::get('Cart')->totalPrice)}} đ</span></h4>
        <input hidden id="total-quantity-cart" type="number" value="{{Session::get('Cart')->totalQuantity}}">
    </div>
    <div class="cart-btn btn-hover">
        <a class="theme-color" href="{{route('cart')}}">Xem giỏ hàng</a>
    </div>
    <div class="checkout-btn btn-hover">
        <a class="theme-color" href="/checkout">Thanh toán</a>
    </div>
@else
    <p style="text-align: center">Giỏ hàng hiện đang trống!</p>
@endif
