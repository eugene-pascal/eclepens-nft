"use strict";

// Class Definition
var KTAddUser = function () {
    // Private Variables
    var _wizardEl;
    var _formEl;
    var _wizard;
    var _avatar;
    var _validations = [];

    // Private Functions
    var _initWizard = function () {
        // Initialize form wizard
        _wizard = new KTWizard(_wizardEl, {
            startStep: 1, // initial active step number
            clickableSteps: true  // allow step clicking
        });

        _wizard.on('submit', function (wizard) {
        });

        // Validation before going to next page
        _wizard.on('beforeNext', function (wizard) {

            // Don't go to the next step yet
            _wizard.stop();

            // Validate form
            var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

            if (3 == wizard.getStep()) {
                $('#reviewFormData').empty();
                var userName = $('#kt_form').find('input[name="name"]').val();
                // var firstName = $('#kt_form').find('input[name="first_name"]').val();
                // var middleName = $('#kt_form').find('input[name="middle_name"]').val();
                // var lastName = $('#kt_form').find('input[name="last_name"]').val();
                var email = $('#kt_form').find('input[name="email"]').val();
                var roleName = $('#kt_form').find('select[name="role"]').find('option:selected').val();

                $('<div>', {
                        class: 'form-group mb-0',
                        html:  '<label class="col-form-label col-xl-3 col-lg-3 font-weight-bolder">First name:</label><span class="col-form-label col-xl-9 col-lg-9 text-primary  font-weight-bold">' + userName + '</span>'
                    })
                    .appendTo($('#reviewFormData'));
                // $('<div>', {
                //         class: 'form-group mb-0',
                //         html:  '<label class="col-form-label col-xl-3 col-lg-3 font-weight-bolder">First name:</label><span class="col-form-label col-xl-9 col-lg-9 text-primary  font-weight-bold">' + firstName + '</span>'
                //     })
                //     .appendTo($('#reviewFormData'));
                //
                // $('<div>', {
                //         class: 'form-group mb-0',
                //         html:  '<label class="col-form-label col-xl-3 col-lg-3 font-weight-bolder">Middle name:</label><span class="col-form-label col-xl-9 col-lg-9 text-primary  font-weight-bold">' + middleName + '</span>'
                //     })
                //     .appendTo($('#reviewFormData'));
                //
                // $('<div>', {
                //         class: 'form-group mb-0',
                //         html:  '<label class="col-form-label col-xl-3 col-lg-3 font-weight-bolder">Last name:</label><span class="col-form-label col-xl-9 col-lg-9 text-primary  font-weight-bold">' + lastName + '</span>'
                //     })
                //     .appendTo($('#reviewFormData'));

                $('<div>', {
                        class: 'form-group mb-0',
                        html:  '<label class="col-form-label col-xl-3 col-lg-3 font-weight-bolder">Email:</label><span class="col-form-label col-xl-9 col-lg-9 text-primary  font-weight-bold">' + email + '</span>'
                    })
                    .appendTo($('#reviewFormData'));

                $('<div>', {
                        class: 'form-group mb-0',
                        html:  '<label class="col-form-label col-xl-3 col-lg-3 font-weight-bolder">Role:</label><span class="col-form-label col-xl-9 col-lg-9 text-primary  font-weight-bold">' + roleName + '</span>'
                    })
                    .appendTo($('#reviewFormData'));
            }

            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    _wizard.goNext();
                    KTUtil.scrollTop();
                } else {
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light"
                        }
                    }).then(function() {
                        KTUtil.scrollTop();
                    });
                }
            });
        });

        // Change Event
        _wizard.on('change', function (wizard) {
            KTUtil.scrollTop();
        });

    }

    var _initValidations = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

        // Validation Rules For Step 1
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'User Name is required'
                            }
                        }
                    },
                    // first_name: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'First Name is required'
                    //         }
                    //     }
                    // },
                    // last_name: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Last Name is required'
                    //         }
                    //     }
                    // },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            },
                            remote: {
                                data: {
                                    _token: _formEl.querySelector('[name="_token"]').value,
                                },
                                message: 'The email is already existed',
                                method: 'POST',
                                url: _formEl.querySelector('[name="match_email_url"]').value,
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        ));

        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            },
                            stringLength: {
                                min: 6,
                                message: 'The password must be not less than 6 characters'
                            }
                        }
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            },
                            identical: {
                                compare: function() {
                                    return _formEl.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                    // submitButton: new FormValidation.plugins.SubmitButton(),
                }
            }
        ));

        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    role: {
                        validators: {
                            notEmpty: {
                                message: 'The role is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                }
            }
        ));

        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        ));
    }

    var _initAvatar = function () {
        _avatar = new KTImageInput('kt_user_add_avatar');
    }

    var _initSubmit = function() {
        var btn = $('#kt_form').find('[data-wizard-type="action-submit"]');

        btn.on('click', function(e) {
            if (!_wizard.isLastStep()) {
                e.preventDefault();
            }
        });
    }

    return {
        // public functions
        init: function () {
            _wizardEl = KTUtil.getById('kt_wizard');
            _formEl = KTUtil.getById('kt_form');

            _initWizard();
            _initValidations();
            // _initAvatar();
            _initSubmit();

        }
    };
}();

jQuery(document).ready(function () {
    KTAddUser.init();
});
