<div class="flex-row-fluid ml-lg-8">
    <!--begin::Card-->
    <div class="card card-custom card-stretch">

        <form
                method="POST"
                action="{{ route('member.profile', ['member' => $member, 'tab'=>'personal']) }}"
                id="payout-methods-form">
        @csrf
        @method('PUT')

        <!--begin::Header-->
            <div class="card-header py-3">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark">@lang('Personal member information')</h3>
                    <span class="text-muted font-weight-bold font-size-sm mt-1">@lang('Update common data of :member', ['member'=>'<span class="font-weight-bolder text-primary">'.$member->getFullName().'</span>'])</span>
                </div>
                <div class="card-toolbar">
                    <button type="Submit" class="btn btn-success mr-2">@lang('Save changes')</button>
                    <button type="reset" class="btn btn-secondary">@lang('Cancel')</button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
            @if(session('successOnUpdate'))
                <!--begin::Alert-->
                    <div class="alert alert-custom alert-light-success fade show mb-10" role="alert">
                        <div class="alert-icon">
                            <span class="svg-icon svg-icon-3x svg-icon-success">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Info-circle.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                        <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1" />
                                        <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <div class="alert-text font-weight-bold">{{ __('Updated') }}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="ki ki-close"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    <!--end::Alert-->
            @endif
            @if($errors->any())
                <!--begin::Alert-->
                    <div class="alert alert-custom alert-light-danger fade show mb-10" role="alert">
                        <div class="alert-icon">
                            <span class="svg-icon svg-icon-3x svg-icon-danger">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Info-circle.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                        <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1" />
                                        <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <div class="alert-text font-weight-bold">{{ $errors->first() }}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="ki ki-close"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    <!--end::Alert-->
                @endif
                <div class="row">
                    <label class="col-xl-3"></label>
                    <div class="col-lg-9 col-xl-6">
                        <h5 class="font-weight-bold mb-6">@lang('Account common info')</h5>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label" for="name" class="required">Nickname</label>
                    <div class="col-lg-9 col-xl-6">
                        <input type="text" class="form-control form-control-lg form-control-solid" name="name" value="{{old('name', $member->name ?? '')}}" id="members_name" placeholder="Member name"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label" for="first_name" class="required">First name</label>
                    <div class="col-lg-9 col-xl-6">
                        <input type="text" class="form-control form-control-lg form-control-solid" name="first_name" value="{{old('first_name', $member->first_name ?? '')}}" id="first_name" placeholder="Member first name"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label" for="last_name" class="required">Last name</label>
                    <div class="col-lg-9 col-xl-6">
                        <input type="text" class="form-control form-control-lg form-control-solid" name="last_name" value="{{old('first_name', $member->last_name ?? '')}}" id="first_name" placeholder="Member last name"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label" for="last_name" class="required">Email</label>
                    <div class="col-lg-9 col-xl-6">
                        <input disabled="disabled" type="text" class="form-control form-control-lg form-control-solid" name="email" value="{{old('email', $member->email ?? '')}}" id="email" placeholder="email"/>
                        <span class="form-text text-muted">Email can't be edited because it is member login into system</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">Status</label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="checkbox-inline">
                            <label class="checkbox m-0">
                                <input type="checkbox" name="status" {{ $member->status == 1 ? 'checked' : '' }} />
                                <span></span>Uncheck it to make account inactive</label>
                        </div>
                        <p class="form-text text-muted py-2">Pay attention that deactivated member won't be able to do any actions</p>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </form>
        <!--end::Form-->
    </div>
</div>