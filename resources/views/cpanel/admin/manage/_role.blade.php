<div class="flex-row-fluid ml-lg-8">
    <!--begin::Card-->
    <div class="card card-custom">
        <!--begin::Form-->
         <form 
            method="POST" 
            action="{{ route('employees.manage', ['employee' => $employee, 'tab'=>'role']) }}" 
            id="payout-methods-form">
            @csrf
            @method('PUT')

            <!--begin::Header-->
            <div class="card-header py-3">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark">Assign Role</h3>
                    <span class="text-muted font-weight-bold font-size-sm mt-1">Assign role to employee account</span>
                </div>
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
            <!--end::Header-->

            <div class="card-body">
                
                @include('pages.widgets._alert_both_success_error', [])

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">Choose role</label>
                    <div class="col-lg-9 col-xl-6">
                        <select class="form-control form-control-solid" name="role">
                            <option value="">-- choose role --</option>
                            @foreach ($rolesArr as $roleIndx=>$roleName)
                                <option value="{{ $roleName }}"{{ $employee->hasRole( $roleName ) ? ' selected="selected"' : '' }}>{{ $roleName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>