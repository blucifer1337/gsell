@extends('admin.layouts.app')
@section('panel')
<div class="row mb-4">
    <div class="col">
        <form action="{{ route('admin.product.license.search') }}" method="post" class="form-inline float-sm-end">
            @csrf
            <div class="input-group">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search Keys')"
                    value="{{ request()->search }}" required>
                <input type="hidden" name="product_id" value="{{ $id }}">
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
                                <th>@lang('License Key')</th>
                                <th>@lang('Created at')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($licenseKeys as $licenseKey)
                            <tr>
                                <td>{{ $licenseKey->license_key }}</td>
                                <td>{{ showDateTime($licenseKey->created_at) }}</td>
                                <td>
                                    @if($licenseKey->status == 0)
                                    <span class="badge badge--success">
                                        @lang('Available')
                                    </span>
                                    @else
                                    @if($licenseKey->user_id != 0)
                                    <span class="badge badge--warning">
                                        @lang('Sold to')
                                    </span>
                                    <a href="{{ route('admin.users.detail', $licenseKey->user->id) }}">{{
                                        '@'.$licenseKey->user->username }}</a>
                                    @else
                                    <span class="badge badge--warning">
                                        @lang('Sold')
                                    </span>
                                    @endif
                                    @endif
                                </td>
                                <td>
                                    <button title="@lang('Edit')"
                                        class="btn btn-sm btn--warning"
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-object="{{ $licenseKey }}"
                                        data-action="{{ route('admin.product.license.update', $licenseKey->id) }}">
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
            @if ($licenseKeys->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($licenseKeys) }}
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
                <h5 class="modal-title">@lang('Add license Keys')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.product.license.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('You can add multiple keys at once, just put them in seperate lines')</label>
                        <textarea name="keys" id="" cols="30" rows="10" required></textarea>
                        <input type="hidden" name="product_id" value="{{ $id }}">
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
                <h5 class="modal-title">@lang('Edit license Key')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" action="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Key')</label>
                        <input type="text" name="license_key" id="key" class="form-control" required>
                        <input type="hidden" name="product_id" value="{{ $id }}">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('Status')</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="0"> @lang('Available') </option>
                            <option value="1"> @lang('Sold') </option>
                        </select>
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
<button type="button" class="btn btn-sm btn--primary" data-bs-toggle="modal" data-bs-target="#addModal">@lang('Add
    New Keys')</button>
@endpush

@push('script')
<script>
    "use strict";
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        var data = button.data('object');
        var action = button.data('action');
        modal.find('.modal-body #key').val(data.license_key)
        modal.find('.modal-body #status').val(data.status)
        $('#editForm').attr('action', action);
    });

</script>
@endpush