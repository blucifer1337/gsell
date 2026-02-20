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
                                <th>@lang('Name')</th>
                                <th>@lang('Icon')</th>
                                <th>@lang('Is Menu Item?')</th>
                                <th>@lang('Created at')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $device)
                            <tr>
                                <td>{{ __($device->name) }}</td>
                                <td>
                                    @php echo __($device->icon) @endphp
                                </td>
                                <td>
                                    @if($device->is_menu_item == 1)
                                    <span class="badge badge--success">@lang('Yes')</span>
                                    @else
                                    <span class="badge badge--warning">@lang('No')</span>
                                    @endif
                                </td>
                                <td>{{ showDateTime($device->created_at) }}</td>
                                <td>
                                    <button title="@lang('Edit')"
                                        class="btn btn-sm btn--warning"
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-object="{{ $device }}"
                                        data-action="{{ route('admin.device.update', $device->id) }}">
                                        <i class="las la-pen"></i>
                                    </button>
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
            @if ($devices->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($categories) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add Device')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.device.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Name')</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Add to Main Menu')</label>
                        <select name="is_menu_item" id="" class="form-control">
                            <option value="0">@lang('No')</option>
                            <option value="1">@lang('Yes')</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="social_icon" class="required">@lang('Select Icon')</label>
                        <div class="input-group iconpicker-container">
                            <input id="social_icon" type="text"
                                class="form-control iconPicker icon iconpicker-element iconpicker-input"
                                autocomplete="off" name="icon" value="{{ old('icon') }}" required=""
                                id="social_icon">
                            <span class="input-group-text  input-group-addon" data-icon="las la-home"
                                role="iconpicker"><i class=""></i></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-global bg--primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Edit Device')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" action="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Name')</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Add to Main Menu')</label>
                        <select name="is_menu_item" id="menu" class="form-control">
                            <option value="0">@lang('No')</option>
                            <option value="1">@lang('Yes')</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="social_icon" class="required">@lang('Select Icon')</label>
                        <div class="input-group iconpicker-container">
                            <input id="social_icon" type="text"
                                class="form-control iconPicker icon iconpicker-element iconpicker-input"
                                autocomplete="off" name="icon" value="{{ old('icon') }}" required=""
                                id="social_icon">
                            <span class="input-group-text  input-group-addon" data-icon="las la-home"
                                role="iconpicker"><i class=""></i></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-global bg--primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<button type="button" class="btn btn-sm btn--primary" data-bs-toggle="modal" data-bs-target="#addModal">@lang('Add New')</button>
@endpush

@push('script')
<script>
    "use strict";
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var data = button.data('object');
        var action = button.data('action');
        modal.find('.modal-body #name').val(data.name)
        modal.find('.modal-body #menu').val(data.is_menu_item)
        $('#editForm').attr('action', action);
    });

    $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
            $(this).closest('.form-group').find('.iconpicker-input').val(`<i class="${e.iconpickerValue}"></i>`);
    });

</script>
@endpush
@push('style-lib')
    <link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
@endpush
