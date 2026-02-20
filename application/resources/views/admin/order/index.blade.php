@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Order Date')</th>
                                    <th>@lang('Order Number')</th>
                                    <th>@lang('Order Type')</th>
                                    <th>@lang('Items')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    @php
                                        $user = App\Models\User::find($order->user_id);
                                        $data = json_decode($order->topup_data, true);
                                    @endphp
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ showDateTime($order->created_at) }}</td>
                                        <td>{{ $order->number }}</td>
                                        <td>{{$order->type == 1 ? 'Product' : 'Top Up' }}</td>
                                        <td>
                                            {{$order->type == 1 ? $order->products->count() : $data['quantity']}}
                                        </td>
                                        <td>{{ $general->cur_sym }}{{ showAmount($order->amount) }}</td>
                                        <td>{{ $user->firstname . ' ' . $user->lastname }}</td>
                                        <td data-label="Status">@php echo $order->statusBadge($order->status) @endphp</td>
                                        <td>
                                            <a title="@lang('Show Details')"
                                               href="{{route('admin.order.details', [ $order->id, slug($order->number)])}}"
                                                class="btn btn-sm btn--primary">
                                                <i class="las la-eye"></i>
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
                @if ($orders->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($orders) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection
