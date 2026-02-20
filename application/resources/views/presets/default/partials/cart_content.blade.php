 <div class="form--check mb-20">
     <input class="form-check-input filter-by-category allSelectedItems" onchange="allSelectedItems(this)" name="categories" type="checkbox" value="1" id="categories">
     <label class="form-check-label" for="chekbox-0">
         @lang('SELECT ALL ')(<span class="allItemCounts">0</span>@lang(' ITEMS'))
     </label>
 </div>
 @foreach ($items as $item)
     <a href="#">
         <div class="cart-item-card">
             <div class="form--check mb-20">
                 <input class="form-check-input " data-price="{{$item['price']}}"
                        onchange="updatProducSelection(this)" name="products[]"
                        type="checkbox" value="{{ $item['id'] }}">
             </div>
             <div class="thumb">
                 <img src="{{ getImage(getFilePath('product') . '/' . $item['image']) }}" alt="...">
             </div>
             <div class="content">
                 <h6 class="title">
                    @if (strlen(__($item['name'])) > 18)
                        {{ substr(__($item['name']), 0, 32) . '...' }}
                    @else
                        {{ __($item['name']) }}
                    @endif
                </h6>
                 <p class="price">{{ $general->cur_sym }}{{ showAmount($item['price']) }} </p>
             </div>
             <div class="user-cta wrapper">
                <div class="quantity_box diplay_flex">
                    <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                    <input class="form--control count-input " type="number" min="1" id="quantityInput"
                            data-limit="{{ App\Models\LicenseKey::whereStatus(0)->whereProductId($item['id'])->count() }}"
                            value="{{ $item['quantity'] }}" readonly>
                    <button type="button" class="add"><i class="fa fa-plus"></i></button>
                </div>
             </div>
             <div class="delete-wrap">
                <button class="trash-btn" onclick="deleteCartItem('{{ $item['id'] }}')"><i
                    class="fas fa-trash-alt"></i></button>
             </div>
         </div>
     </a>
 @endforeach

