@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-4">
        <div class="col">
            <form action="{{ route('admin.topup.search') }}" method="post" class="form-inline float-sm-end">
                @csrf
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search Top Ups')"
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
                                    <th>@lang('Available Items')</th>
                                    <th>@lang('Created at')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($topUps as $topUp)
                                    @php
                                        $data = collect($topUp->services_data)->count();
                                    @endphp
                                    <tr>
                                        <td><img src="{{ getImage(getFilePath('topup') . '/' . $topUp->image) }}" alt="topUp"
                                                width="100"></td>
                                        <td>
                                            @if (strlen(__($topUp->name)) > 18)
                                                {{ substr(__($topUp->name), 0, 29) . '...' }}
                                            @else
                                                {{ __($topUp->name) }}
                                            @endif
                                        </td>
                                        <td>{{ $data }}
                                        </td>
                                        <td>{{ showDateTime($topUp->created_at) }}</td>
                                        <td>@php echo $topUp->statusBadge($topUp->status); @endphp
                                            @if ($topUp->is_trending == 1)
                                                <span class="badge badge--primary">@lang('Trending')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a title="@lang('Edit')" href="{{ route('admin.topup.edit', $topUp->id) }}"
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
                @if ($topUps->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($topUps) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a type="button" class="btn btn-sm btn--primary" href="{{ route('admin.topup.create') }}">@lang('Add New')</a>
@endpush
