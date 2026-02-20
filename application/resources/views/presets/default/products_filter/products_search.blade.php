    <div class="row gy-4">
        @forelse ($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                <a class="card-link-wrapper" href="{{ route('product', ['slug' => slug($product->title), 'id' => $product->id]) }}">
                    <div class="game-card">
                        @if ($product->discount > 0)
                            <div class="dis-tag">
                                <p>-{{ $product->discount }}%</p>
                            </div>
                        @endif
                        <div class="thumb">
                            <img src="{{ getImage(getFilePath('product') . '/' . $product->image) }}" alt="...">
                        </div>
                        <div class="content">
                            <h6 class="title">
                                @if (strlen(__($product->title)) > 30)
                                    {{ substr(__($product->title), 0, 55) . '...' }}
                                @else
                                    {{ __($product->title) }}
                                @endif
                            </h6>
                            <ul>
                                @php echo __(@$product->platform?->icon) @endphp
                                @php echo __(@$product->device?->icon) @endphp
                            </ul>
                            <div class="price-wrap">
                                @if ($product->discount > 0)
                                    <p class="price">
                                        {{ $general->cur_sym }}{{ showAmount($product->final_amount) }} </p>
                                    <span class="dis-price">
                                        {{ $general->cur_sym }}{{ showAmount($product->price) }}
                                    </span>
                                @else
                                    <p class="price">
                                        {{ $general->cur_sym }}{{ showAmount($product->price) }} </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div>
                <p class="text-muted text-center" colspan="100%">@lang('No Product Found')</p>
            </div>
        @endforelse

    </div>
