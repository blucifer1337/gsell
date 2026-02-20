@php
    $user = auth()->user();
    $userFname = $user->firstname;
    $userLname = $user->lastname;
    $fullname = $userFname . ' ' . $userLname;
    $fullAddress = @$user->address->address . ', ' . @$user->address->state . ', ' . @$user->address->city . ' - ' . @$user->address->zip . ', ' . @$user->address->country;
@endphp
@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="user-profile-section bg--black">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="dashboard-body py-60">
                            <div class="row gy-4">
                                <div class="col-lg-12">
                                    <div class="profile-wrap p-4 card-bg rounded">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="dashboard_profile-card">
                                                    <div class="user-profile text-center">
                                                        <div class="dashboard_profile_wrap">
                                                            <form action="{{ route('user.change.image', $user->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="profile_photo">
                                                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image) }}" alt="@lang('agent')">
                                                                    <div class="photo_upload">
                                                                        <label for="file_upload"><i class="fas fa-image"></i></label>
                                                                        <input id="file_upload" name="file_upload" type="file" class="upload_file"
                                                                            onchange="this.form.submit()">
                                                                    </div>
                                                                </div>
                                                            </form>

                                                            <div class="profile-details">
                                                                <ul>
                                                                    <li>
                                                                        <p>@lang('Name :') {{ __($fullname) }}</p>
                                                                        <p class="user-name">{{ __($user->username) }}</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="contact-info">
                                                        <div class="info-wrap">
                                                            <div class="info">
                                                                <i class="far fa-envelope"></i>
                                                                <p>@lang('Email Address')</p>
                                                            </div>
                                                            <p>{{ __($user->email) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="contact-info">
                                                        <div class="info-wrap">
                                                            <div class="info">
                                                                <i class="fas fa-phone"></i>
                                                                <p>@lang('Mobile Number')</p>
                                                            </div>
                                                            <p>@lang('+'){{ __($user->mobile) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="contact-info">
                                                        <div class="info-wrap">
                                                            <div class="info">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                <p>@lang('Address')</p>
                                                            </div>
                                                            <p>{{ __($fullAddress) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 justify-content-center">
                                                <div class="global-card">
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row gy-3">
                                                            <div class="col-lg-12">
                                                                <h4 class="mb-1">@lang('Personal Information')</h4>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-3">
                                                                    <label for="name"
                                                                        class="form--label mb-3">@lang('First Name')</label>
                                                                    <input type="text" class="form-control form--control"
                                                                        name="firstname" value="{{ $user->firstname }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-3">
                                                                    <label for="lastname"
                                                                        class="form--label mb-3">@lang('Last Name')</label>
                                                                    <input type="text" class="form-control form--control"
                                                                        name="lastname" value="{{ $user->lastname }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-3">
                                                                    <label
                                                                        class="form--label mb-2">@lang('E-mail Address')</label>
                                                                    <input class="form-control form--control"
                                                                        value="{{ $user->email }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-3">
                                                                    <label
                                                                        class="form--label mb-2">@lang('Mobile Number')</label>
                                                                    <input class="form-control form--control"
                                                                        value="{{ $user->mobile }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-3">
                                                                    <label for="country"
                                                                        class="form--label mb-2">@lang('Address')</label>
                                                                    <input type="text" class="form-control form--control"
                                                                        name="address"
                                                                        value="{{ $user->address !== null ? @$user->address->address : '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-3">
                                                                    <label for="zip-code"
                                                                        class="form--label mb-2">@lang('Postal')</label>
                                                                    <input type="text" class="form-control form--control"
                                                                        name="state"
                                                                        value="{{ $user->address !== null ? @$user->address->state : '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="zip-code"
                                                                        class="form--label mb-2">@lang('Zip Code')</label>
                                                                    <input type="text" class="form-control form--control"
                                                                        name="zip" value="{{ @$user->address->zip }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="zip-code"
                                                                        class="form--label mb-2">@lang('City')</label>
                                                                    <input type="text"
                                                                        class="form-control form--control" name="city"
                                                                        value="{{ @$user->address->city }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="zip-code"
                                                                        class="form--label mb-2">@lang('Country')</label>
                                                                    <input class="form-control form--control"
                                                                        value="{{ @$user->address->country }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <button type="submit"
                                                                    class="btn btn--base w-100">@lang('Save Now')</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
