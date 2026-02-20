@php
    $data = json_decode($order->topup_data, true);
@endphp
@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            @if($order->type == 1)
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('SL')</th>
                                    <th class="text-center">@lang('Title')</th>
                                    <th class="text-center">@lang('Price')</th>
                                    <th class="text-center">@lang('Game KEY')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($licenseKeys as $licenseKey)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ __($licenseKey->product->title) }}</td>
                                        <td>{{ $general->cur_sym }} {{ showAmount($licenseKey->product->final_amount) }}</td>
                                        <td>{{ $licenseKey->license_key }}</td>
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
            </div><!-- card end -->
            @else
            <div class="col-xl-6 col-md-6 mb-30">
                <div class="card b-radius--10 overflow-hidden box--shadow1">
                    <div class="card-body">
                        <h5 class="mb-20 text-muted">@lang('Quantity: ')<span class="fw-bold">{{ $data['quantity'] }}</span></h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Date')
                                <span class="fw-bold">{{ showDateTime($order->created_at) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Username')
                                <span class="fw-bold">
                                    <a href="{{ route('admin.users.detail', $order->user_id) }}">{{ @$order->user->username
                                        }}</a>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Game ID')
                                <span class="fw-bold">{{ $data['game_id'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Server Information')
                                <span class="fw-bold">{{ $data['server_info'] ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('User Information')
                                <span class="fw-bold">{{ isset($data['user_info']) ? $data['user_info'] : 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Amount')
                                <span class="fw-bold">{{ showAmount($order->amount ) }} {{ __($general->cur_text) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Status')
                                @php echo $order->statusBadge($order->status) @endphp
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
