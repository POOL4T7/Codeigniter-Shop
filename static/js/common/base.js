

$(document).ready(function () {
    jQuery.extend(jQuery.validator.messages, {
        required: "This field is required",
        remote: "Please fix this field",
        email: "Please enter a valid email address",
        url: "Please enter a valid URL (url must start with http:// or https://)",
        date: "Please enter a valid date",
        dateISO: "Please enter a valid date ( ISO )",
        number: "Please enter a valid number",
        digits: "Please enter only digits",
        creditcard: "Please enter a valid credit card number",
        equalTo: "Please enter the same value again",
        maxlength: $.validator.format("Please enter no more than {0} characters"),
        minlength: $.validator.format("Please enter at least {0} characters"),
        rangelength: $.validator.format("Please enter a value between {0} and {1} characters long"),
        range: $.validator.format("Please enter a value between {0} and {1}"),
        max: $.validator.format("Please enter a value less than or equal to {0}"),
        min: $.validator.format("Please enter a value greater than or equal to {0}")
    });
    validate();
});
function validate() {

    var global_greater_than_value;
    $.validator.addMethod("greater_than", function (element_value, element, value) {
        global_greater_than_value = value;
        return this.optional(element) || element_value > value;
    }, function () {
        return "Please enter a value greater than " + global_greater_than_value;
    });
    $.validator.addMethod("alpha", function (value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
    });
    $.validator.addMethod("not_equal_to", function (element_value, element, value) {
        return this.optional(element) || element_value.toLowerCase() != value.toLowerCase();
    }, function () {
        return "Enter value is not allowed";
    });
    $.validator.addMethod("email", function (email, element) {
        var email_splitted = email.split("@");
        var is_email_valid = false;
        if (typeof email_splitted[1] !== 'undefined' && email_splitted[1] === "library.com") {
            is_email_valid = true;
        } else {
            var username;
            username = typeof email_splitted[0] !== 'undefined' ? email_splitted[0] : "";
            if (username.indexOf('+') > -1)
            {
                is_email_valid = false;
            } else {
                is_email_valid = true;
            }
        }
        return this.optional(element) || ((email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/) && is_email_valid));
    }, "Please enter a valid email address");
    $.validator.addMethod("countrycode", function (country_code, element) {
        return this.optional(element) || (country_code.match(/^[/\s+/][0-9]+$/) && country_code.length <= 5);
    }, "Please specify a valid country code starting with +");
    $.validator.addMethod("mobilenumber", function (mobile_number, element) {
        return this.optional(element) || mobile_number.match(/^[6789][0-9]{9}$/);
    }, "Please specify a valid phone number");
    $.validator.addMethod("onlynumbers", function (only_numbers, element) {
        return this.optional(element) || only_numbers.match(/^[0-9]+$/);
    }, "Please enter only numbers");
    $.validator.addMethod("nonumbers", function (no_numbers, element) {
        return this.optional(element) || no_numbers.match(/^[^0-9]+$/);
    }, "Please do not enter any number");
    $.validator.addMethod("onlyalpha", function (only_alpha, element) {
        return this.optional(element) || (only_alpha.match(/^[a-zA-Z ]+$/));
    }, "Please enter only alphabets");
    $.validator.addMethod("user_name", function (only_alpha, element) {
        return this.optional(element) || (only_alpha.match(/^[a-zA-Z .]+$/));
    }, "Please enter only alphabets");
    $.validator.addMethod("decimalnumbers", function (decimal_numbers, element, allow_decimals) {
        if (!allow_decimals) {
            return this.optional(element) || decimal_numbers.match(/^[0-9]+$/);
        }
        return this.optional(element) || (decimal_numbers.match(/^[0-9]+[.]+[0-9]+$/) || decimal_numbers.match(/^[0-9]+$/));
    }, "Please enter only number or decimal number");
    $.validator.addMethod("basicstring", function (basic_string, element) {
        return this.optional(element) || basic_string.match(/^[a-zA-Z]+[a-zA-Z .(),&']*$/) || basic_string === "10th" || basic_string === "12th" || basic_string.indexOf("5 Years") !== -1;
    }, "Please enter only valid characters");
    $.validator.addMethod('filesize', function (value, element, param) {
        // param = size (en bytes)
        // element = element to validate (<input>)
        // value = value of the element (file name)
        return this.optional(element) || (element.files[0].size <= param)
    }, "Please obey the file size");
}

function preview_image(event)
{
    var reader = new FileReader();
    reader.onload = function ()
    {
        var output = document.getElementById('output_image');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}


function call_autocomplete(id, request_for, multiselect) {
    var selected = [];
    var no_result_found_string = "No match found";
    $("#" + id)
            .bind("keydown", function (event) {
                if (event.keyCode === $.ui.keyCode.TAB && $(this).data("ui-autocomplete").menu.active) {
                    event.preventDefault();
                }
            })
            .autocomplete({
//                delay: 300,
                source: function (request, response) {
                    var where_condition = $("#" + id).attr("where_condition");
                    if (typeof where_condition == 'undefined') {
                        where_condition = "0";
                    }
                    var where_params = $("#" + id).attr("where_params");
                    if (typeof where_params == 'undefined') {
                        where_params = "0";
                    }


                    var term = encodeURIComponent(extractLast(request.term));
                    if (request_for != '' && term != '' && term != '.') {
                        $.ajax({
                            type: "POST",
                            contentType: "application/json; charset=utf-8",
                            url: "/autocomplete/" + request_for + "/" + term + "/" + where_condition + "/" + where_params,
                            dataType: "json",
                            success: function (data) {
                                if (data.result.length == 0) {
                                    response([no_result_found_string]);
                                } else {
                                    response(data.result);
                                }
                            }
                        });
                    }
                },
                minLength: function () {
                    return 3;
                }(),
                focus: function () {
                    return false;
                },
                autoFocus: false,
                select: function (event, ui) {
                    if (multiselect) {
                        var terms = split(this.value);
                        terms.pop();
                        terms.push(ui.item.value);
                        terms.push("");
                        this.value = terms.join(",");
                        return false;
                    } else {
                    }
                },
                change: function (event, ui) {

                }
            });
    function extractLast(term) {
        return split(term).pop();
    }

    function split(val) {
        return val.split(/,\s*/);
    }

    return selected;
}
    