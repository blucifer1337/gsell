@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <form action="{{ route('admin.product.dispatch', $product->id) }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-between px-2 py-3">
                            <h5>{{ $product->title }}</h5>
                            <button class="btn btn--primary input-group-text form-inline float-sm-end"
                                type="submit">@lang('Dispatch ') <i class="fas fa-plane-departure"></i></button>
                            </div>
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="allSelectedItems" value="1"
                                            id="ordersCheckBox" name="ordersCheckBox" onclick="allSelectedItems(this)">
                                            <label class="form-check-label" for="chekbox-0">
                                                @lang('SELECT ALL ')(<span class="allItemCounts">0</span>@lang(' ITEMS'))
                                            </label>
                                        </th>
                                        <th>@lang('Order Date')</th>
                                        <th>@lang('Order Number')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('User')</th>
                                        <th>@lang('Status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        @php
                                            $user = App\Models\User::find($order->user_id);
                                        @endphp
                                        <tr>
                                            <td><input type="checkbox" name="orders[]" value="{{ $order->id }}"
                                                    data-order="{{ $order->id }}" onclick="updatOrderSelection(this)">
                                            </td>
                                            <td>{{ showDateTime($order->created_at) }}</td>
                                            <td>{{ $order->number }}</td>
                                            <td>{{ $general->cur_sym }}{{ showAmount($order->amount) }}</td>
                                            <td>{{ $user->firstname . ' ' . $user->lastname }}</td>
                                            <td data-label="Status">@php echo $order->statusBadge($order->status) @endphp</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table><!-- table end -->
                        </form>

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

@push('breadcrumb-plugins')
    <a type="button" class="btn btn-sm btn--primary" href="{{ route('admin.product.index') }}">@lang('Back')</a>
@endpush

@push('script')
    <script>

        function allSelectedItems(object) {
            var checked = $(object).is(":checked");
            if (checked) {
                toggleSelectedItems(true);
            } else {
                toggleSelectedItems(false);
            }
            updatOrderSelection(this);
        }

        function toggleSelectedItems(checked) {
            let orders = $("input[name='orders[]']");
            orders.each(function(index, order) {
                $(order).prop('checked', checked);
            })
        }

        function updatOrderSelection(object) {
            $('.allItemCounts').text(totalSelectedOrders());

            $('.allSelectedItems').prop('checked', anyItemChecked());
        }

        function anyItemChecked() {
            let orders = $("input[name='orders[]']")
            var isAllSelected = true;
            orders.each(function(index, order) {
                if (!$(order).is(":checked")) {
                    isAllSelected = false;
                }
            })
            return isAllSelected;
        }
        function totalSelectedOrders() {
            let orders = $("input[name='orders[]']");
            var selectedIds = [];
            orders.each(function(index, order) {
                if ($(order).is(":checked")) {
                    selectedIds.push($(order).val());
                }
            })
            return selectedIds.length
        }
    </script>
@endpush
