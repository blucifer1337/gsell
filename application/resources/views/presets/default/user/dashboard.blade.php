@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="dashboard-section py-80 bg--black">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tbl-wrap">
                            <div class="dashboard-title">
                                <h6 class="title">@lang('Your Order')</h6>
                            </div>
                            <div class="dashboard-table-wrapper">
                                <table class="table table--responsive--lg">
                                    <thead>
                                        <tr>
                                            <th>@lang('Order Date')</th>
                                            <th>@lang('Order Number')</th>
                                            <th>@lang('Order Type')</th>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td data-label="Order Date">{{ showDateTime($order->created_at) }}</td>
                                                <td data-label="Order Number">{{ $order->number }}</td>
                                                <td data-label="Order Type">{{$order->type == 1 ? 'Product' : 'Top Up' }}</td>
                                                <td data-label="Price">
                                                    {{ $general->cur_sym }}{{ showAmount($order->amount) }}</td>
                                                <td data-label="Status">@php echo $order->statusBadge($order->status) @endphp</td>
                                                <td data-label="Action">
                                                    <a href="{{ route('user.orders', $order->id) }}"
                                                        class="d-flex justify-content-end">
                                                        <p class="badge badge--base text">@lang('Veiw Details')</p>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-muted text-center" colspan="100%">
                                                    {{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="dashboard-pagination mb-5">
                                    @if ($orders->hasPages())
                                        <div class="card-footer text-end">
                                            {{ $orders->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
