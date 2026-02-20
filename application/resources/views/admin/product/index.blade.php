@extends('admin.layouts.app')

@section('panel')
<div class="row mb-4">
    <div class="col">
        <form action="{{ route('admin.product.search') }}" method="post" class="form-inline float-sm-end">
            @csrf
            <div class="input-group">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search Products')"
                    value="{{ request()->search }}" required>
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Image')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Discount')</th>
                                <th>@lang('Available Keys')</th>
                                <th>@lang('Created at')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td><img src="{{getImage(getFilePath('product').'/'.$product->image)}}"
                                        alt="product" width="100"></td>

                                <td>
                                    @if (strlen(__($product->title)) > 18)
                                        {{ substr(__($product->title), 0, 29) . '...' }}
                                    @else
                                        {{ __($product->title) }}
                                    @endif
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $general->cur_sym }}{{ showAmount($product->price) }}</td>
                                <td>{{ showAmount($product->discount) }}</td>
                                <td>{{ App\Models\LicenseKey::whereStatus(0)->whereProductId($product->id)->count() }}
                                </td>
                                <td>{{ showDateTime($product->created_at) }}</td>
                                <td>@php echo $product->statusBadge($product->status); @endphp
                                    @if($product->is_trending == 1) <span
                                        class="badge badge--primary">@lang('Trending')</span> @endif
                                </td>
                                <td>
                                    @if ($product->status == 2)
                                        <a title="@lang('Pre Orders')"
                                            href="{{route('admin.order.preorder', $product->id)}}"
                                            class="btn btn-sm btn--primary">
                                            <i class="las la-list-ul"></i>
                                        </a>
                                    @endif
                                    <a title="@lang('Manage Keys')"
                                        href="{{ route('admin.product.license.keys', $product->id) }}"
                                        class="btn btn-sm btn--primary">
                                        <i class="las la-key"></i>
                                    </a>
                                    <a title="@lang('Edit')"
                                        href="{{ route('admin.product.edit', $product->id) }}"
                                        class="btn btn-sm btn--warning">
                                        <i class="las la-pen"></i>
                                    </a>


                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($products->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($products) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<a type="button" class="btn btn-sm btn--primary" href="{{ route('admin.product.create') }}">@lang('Add
    New')</a>
@endpush
