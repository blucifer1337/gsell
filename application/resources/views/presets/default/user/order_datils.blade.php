@php
    $data = json_decode($order->topup_data, true);
    $topUp = App\Models\TopUp::find($order->topup_id);
@endphp
@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="dashboard-section py-80 bg--black">
        <div class="dashboard">
            <div class="container p-0">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h5 class="text-white mb-4">@lang('Order No:') # {{ __($order->number) }}</h5>
                        @if ($order->type == 1)
                            <div class="table-responsive">
                                <table class="table table--responsive--lg">
                                    <thead>
                                        <tr>
                                            <th class="text-center">@lang('SL')</th>
                                            <th class="text-center">@lang('Image')</th>
                                            <th class="text-center">@lang('Title')</th>
                                            <th class="text-center">@lang('Price')</th>
                                            <th class="text-center">@lang('Detail')</th>
                                            <th class="text-center">@lang('Game KEY')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($licenseKeys as $licenseKey)
                                            <tr>
                                                <td data-label="SL">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td data-label="Image">
                                                    <div class="order_thumb">
                                                        <img src="{{ getImage(getFilePath('product') . '/' . 'thumb_' . $licenseKey->product->image) }}"
                                                            alt="">
                                                    </div>
                                                </td>
                                                <td data-label="Title" class="text-center">
                                                    <a
                                                        href="{{ route('product', ['slug' => slug($licenseKey->product->title), 'id' => $licenseKey->product->id]) }}">{{ __($licenseKey->product->title) }}</a>

                                                </td>
                                                <td data-label="Price" class="text-center">
                                                    {{ $general->cur_sym }}
                                                    {{ showAmount($licenseKey->product->final_amount) }}
                                                </td>
                                                <td data-label="Detail" class="text-center ">
                                                    {{ substr(strip_tags($licenseKey->product->description), 0, 50) . '...' }}
                                                </td>
                                                <td data-label="Game KEY">
                                                    <a href="javascript:void(0)">
                                                        <p class="text-white" data-key="{{ $licenseKey->license_key }}"
                                                            onclick="copyGameKey(this)">
                                                            {{ substr($licenseKey->license_key, 0, 3) }}**********{{ substr($licenseKey->license_key, -3) }}
                                                        </p><br>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td data-label="No Data" colspan="100%" class="text-center">
                                                    @lang('No License Keys Found')
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="col-xl-8 col-md-6 mb-30">
                                <div class="card b-radius--10 overflow-hidden box--shadow1">
                                    <div class="card-body">
                                        <h5 class="mb-20 text-muted"><span class="fw-bold">{{ $topUp->name }}</span>
                                        </h5>
                                        <h5 class="mb-20 text-muted">@lang('Quantity: ')
                                            <span class="fw-bold">{{ $data['quantity'] }}</span>
                                        </h5>
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                @lang('Date')
                                                <span class="fw-bold">{{ showDateTime($order->created_at) }}</span>
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
                                                <span
                                                    class="fw-bold">{{ isset($data['user_info']) ? $data['user_info'] : 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                @lang('Amount')
                                                <span class="fw-bold">{{ showAmount($order->amount) }}
                                                    {{ __($general->cur_text) }}</span>
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
            </div>
        </div>
    </section>


    {{-- APPROVE MODAL --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData mb-2">
                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function copyGameKey(object) {
            "use strict";
            var text = $(object).data('key');
            navigator.clipboard.writeText(text).then(() => {
                Toast.fire({
                    icon: 'success',
                    title: `Game Keys " ${text} "Copied`
                });

            }).catch((error) => {
                Toast.fire({
                    icon: 'error',
                    title: `Error copying text`
                });
            });
        }
    </script>
@endpush
