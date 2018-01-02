$(document).ready(function() {
    var a = {
        valid: "fa fa-check-circle fa-lg text-success",
        invalid: "fa fa-times-circle fa-lg",
        validating: "fa fa-refresh"
    };
    $("#demo-password").bootstrapValidator({
            message: "This value is not valid",
            feedbackIcons: a,
            fields: {
                username: {
                    message: "The username is not valid",
                    validators: {
                        notEmpty: { message: "The username is required." }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: "The password is required and can't be empty"
                        },
                        identical: {
                            field: "confirmPassword",
                            message: "The password and its confirm are not the same"
                        }
                    }
                },
                confirmPassword: {
                    validators: {
                        notEmpty: {
                            message: "The confirm password is required and can't be empty"
                        },
                        identical: {
                            field: "password",
                            message: "The password and its confirm are not the same"
                        }
                    }
                }
            }
        }).on("success.field.bv", function(a, b) {
            var c = b.element.parents(".form-group");
            c.removeClass("has-success")
        }),
        $("#demo-checkboxradio-btn").bootstrapValidator({
            message: "This value is not valid",
            feedbackIcons: a,
            fields: {
                username: {
                    message: "The username is not valid",
                    validators: { notEmpty: { message: "The username is required." } }
                },
                member: {
                    validators: { notEmpty: { message: "The gender is required" } }
                },
                "programs[]": {
                    validators: { choice: { min: 2, max: 4, message: "Please choose 2 - 4 programming languages you are good at" } }
                }
            }
        }).on("success.field.bv", function(a, b) {
            var c = b.element.parents(".form-group");
            c.removeClass("has-success")
        }),
        $("#demo-number").bootstrapValidator({
            message: "This value is not valid",
            feedbackIcons: a,
            fields: {
                username: {
                    message: "The username is not valid",
                    validators: { notEmpty: { message: "The username is required." } }
                },
                integer: {
                    validators: {
                        notEmpty: { message: "The number is required and can't be empty" },
                        integer: { message: "The value is not a number" }
                    }
                },
                numeric: {
                    validators: {
                        notEmpty: { message: "The number is required and can't be empty" },
                        numeric: { message: "The value is not a number" }
                    }
                },
                greaterthan: {
                    validators: {
                        notEmpty: { message: "The number is required and can't be empty" },
                        greaterThan: { inclusive: !1, value: 50, message: "Please enter a value greater than 50" }
                    }
                },
                lessthan: {
                    validators: {
                        notEmpty: { message: "The number is required and can't be empty" },
                        lessThan: { inclusive: !1, value: 25, message: "Please enter a value less than 25" }
                    }
                },
                range: {
                    validators: { inclusive: !0, notEmpty: { message: "The number is required and can't be empty" }, between: { min: 1, max: 100, message: "Please enter a number between 1 and 100" } }
                }
            }
        }).on("success.field.bv", function(a, b) {
            var c = b.element.parents(".form-group");
            c.removeClass("has-success")
        }),
        $("#demo-bvd-notempty").bootstrapValidator({
            message: "This value is not valid",
            feedbackIcons: a,
            fields: {
                username: {
                    message: "The username is not valid",
                    validators: { notEmpty: { message: "The username is required." } }
                },
                uppercase: {
                    validators: {
                        notEmpty: { message: "The card holder is required and can't be empty" },
                        stringCase: { message: "The card holder must be in uppercase", case: "upper" }
                    }
                },
                email: {
                    validators: {
                        notEmpty: { message: "The email address is required and can't be empty" },
                        emailAddress: { message: "The input is not a valid email address" }
                    }
                },
                website: {
                    validators: {
                        notEmpty: { message: "The website address is required and can't be empty" },
                        uri: { allowLocal: !1, message: "The input is not a valid URL" }
                    }
                },
                color: {
                    validators: {
                        notEmpty: { message: "The hex color is required and can't be empty" },
                        hexColor: { message: "The input is not a valid hex color" }
                    }
                }
            }
        }).on("success.field.bv", function(a, b) {
            var c = b.element.parents(".form-group");
            c.removeClass("has-success")
        }),
        $("#registrationForm").bootstrapValidator({
            framework: "bootstrap",
            icon: {
                valid: "glyphicon glyphicon-ok",
                invalid: "glyphicon glyphicon-remove",
                validating: "glyphicon glyphicon-refresh"
            },
            fields: {
                firstName: {
                    row: ".col-xs-4",
                    validators: { notEmpty: { message: "The first name is required" } }
                },
                lastName: {
                    row: ".col-xs-4",
                    validators: { notEmpty: { message: "The last name is required" } }
                },
                username: {
                    validators: {
                        notEmpty: { message: "The username is required" },
                        stringLength: { min: 6, max: 30, message: "The username must be more than 6 and less than 30 characters long" },
                        regexp: { regexp: /^[a-zA-Z0-9_\.]+$/, message: "The username can only consist of alphabetical, number, dot and underscore" }
                    }
                },
                email: {
                    validators: {
                        notEmpty: { message: "The email address is required" },
                        emailAddress: { message: "The input is not a valid email address" }
                    }
                },
                password: {
                    validators: {
                        notEmpty: { message: "The password is required" },
                        different: { field: "username", message: "The password cannot be the same as username" }
                    }
                },
                gender: {
                    validators: {
                        notEmpty: { message: "The gender is required" }
                    }
                },
                agree: {
                    validators: {
                        notEmpty: { message: "You must agree with the terms and conditions" }
                    }
                },
                regionNom: {
                    validators: {
                        notEmpty: { message: "Le nom de la région est obligatoire" }
                    }
                },
                dateNaiss: {
                    validators: {
                        notEmpty: { message: "La date de naissance doit être obligatoire" },
                        //stringLength: { min: 6, max: 30, message: "The username must be more than 6 and less than 30 characters long" },
                        regexp: { regexp: /^[Z0-9-\.]+$/, message: "La date de naissance doit être au format jj-mm-aaaa (ex: 22-02-1941)" }
                    }
                }
            }
        }),
        $("#demo-tooltip-validation").bootstrapValidator({
            message: "This value is not valid",
            excluded: [":disabled"],
            feedbackIcons: a,
            fields: {
                name: {
                    container: "tooltip",
                    validators: {
                        notEmpty: { message: "The first name is required and cannot be empty" },
                        regexp: { regexp: /^[A-Z\s]+$/i, message: "The first name can only consist of alphabetical characters and spaces" }
                    }
                },
                lastName: {
                    validators: {
                        notEmpty: { message: "The last name is required and cannot be empty" },
                        regexp: { regexp: /^[A-Z\s]+$/i, message: "The last name can only consist of alphabetical characters and spaces" }
                    }
                },
                email: {
                    container: "tooltip",
                    validators: {
                        notEmpty: { message: "The email address is required and can't be empty" },
                        emailAddress: { message: "The input is not a valid email address" }
                    }
                }
            }
        }),
        $("#demo-popover-validation").bootstrapValidator({
            message: "This value is not valid",
            excluded: [":disabled"],
            feedbackIcons: a,
            fields: {
                username: {
                    container: "popover",
                    message: "The username is not valid",
                    validators: {
                        notEmpty: { message: "The username is required and cannot be empty" },
                        stringLength: { min: 6, max: 30, message: "The username must be more than 6 and less than 30 characters long" },
                        regexp: { regexp: /^[a-zA-Z0-9_\.]+$/, message: "The username can only consist of alphabetical, number, dot and underscore" },
                        different: { field: "password", message: "The username and password cannot be the same as each other" }
                    }
                },
                password: {
                    container: "popover",
                    validators: {
                        notEmpty: { message: "The password is required and cannot be empty" },
                        different: {
                            field: "username",
                            message: "The password cannot be the same as username"
                        }
                    }
                }
            }
        }),
        $("#demo-custom-container").bootstrapValidator({
            message: "This value is not valid",
            excluded: [":disabled"],
            feedbackIcons: a,
            fields: {
                phoneNumber: {
                    container: "#demo-error-container",
                    validators: {
                        notEmpty: { message: "The phone number is required and cannot be empty" },
                        digits: { message: "The value can contain only digits" }
                    }
                },
                city: {
                    container: "#demo-error-container",
                    validators: { notEmpty: { message: "The city is required and cannot be empty" } }
                }
            }
        }),
        $("#demo-msk-date").mask("99/99/9999")
});