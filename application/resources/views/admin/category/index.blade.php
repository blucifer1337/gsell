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
                                <th>@lang('Is Menu Item?')</th>
                                <th>@lang('Created at')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if($category->is_menu_item == 1)
                                    <span class="badge badge--success">@lang('Yes')</span>
                                    @else
                                    <span class="badge badge--warning">@lang('No')</span>
                                    @endif
                                </td>
                                <td>{{ showDateTime($category->created_at) }}</td>
                                <td>
                                    <button title="@lang('Edit')"
                                        class="btn btn-sm btn--warning"
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-object="{{ $category }}"
                                        data-action="{{ route('admin.category.update', $category->id) }}">
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
            @if ($categories->hasPages())
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
                <h5 class="modal-title">@lang('Add Category')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.category.store') }}" method="post">
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
                <h5 class="modal-title">@lang('Edit Category')</h5>
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
    New')</button>
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

</script>
@endpush