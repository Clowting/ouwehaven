$(document).ready(function ($) {

	$("#signupForm, #changeDetailsForm").validate({
		debug: false,
    	errorClass: 'alert alert-danger alert-form',
	    highlight: function (element, errorClass, validClass) {
	        return false;  // ensure this function stops
	    },
	    unhighlight: function (element, errorClass, validClass) {
	        return false;  // ensure this function stops
	    },
    	//validClass: 'alert alert-success alert-form',
    	errorElement: 'div',
		rules: {
			voornaam: {
		    	required: true,
		    	minlength: 2
		    },
		    tussenvoegsel: {
		    	required: false,
		    	minlength: 1
		    },
			achternaam: {
		    	required: true,
		    	minlength: 2
		    },
			adres: {
		    	required: true,
		    	minlength: 4
		    },
		    postcode: {
		    	required: true,
		    	minlength: 6,
		    	maxlength: 7
		    },
		    woonplaats: {
		    	required: true,
		    	minlength: 2
		    }
		},
		messages: {
			voornaam: {
				required:  "Voer a.u.b. uw voornaam in.",
				minlength: "Voer a.u.b. minimaal 2 tekens in."
			},
			tussenvoegsel: {
				minlength: "Voer a.u.b. minimaal 1 teken in."
			},
			achternaam: {
				required: "Voer a.u.b. uw achternaam in.",
				minlength: "Voer a.u.b. minimaal 2 tekens in."
			},
			adres: {
				required: "Voer a.u.b. uw straat en huisnummer in.",
				minlength: "Voer a.u.b. minimaal 4 tekens in."
			},
			postcode: {
				required: "Voer a.u.b. uw postcode in.",
				minlength: "Voer a.u.b. minimaal 6 tekens in.",
				maxlength: "Voer a.u.b. maximaal 7 tekens in."
			},
			woonplaats: {
				required: "Voer a.u.b. uw woonplaats in.",
				minlength: "Voer a.u.b. minimaal 2 tekens in."
			} 
		},
		submitHandler: function(form) { 
			form.submit();
		}
	});

	$("#addShipForm").validate({
		debug: false,
    	errorClass: 'alert alert-danger alert-form',
	    highlight: function (element, errorClass, validClass) {
	        return false;  // ensure this function stops
	    },
	    unhighlight: function (element, errorClass, validClass) {
	        return false;  // ensure this function stops
	    },
    	//validClass: 'alert alert-success alert-form',
    	errorElement: 'div',
		rules: {
			naam: {
		    	required: true,
		    	minlength: 2
		    },
		    lengte: {
		    	required: true,
		    	number: true,
		    	minlength: 1
		    }
		},
		messages: {
			naam: {
				required:  "Voer a.u.b. de naam van het schip in.",
				minlength: "Voer a.u.b. minimaal 2 tekens in."
			},
			lengte: {
				required:  "Voer a.u.b. de lengte van het schip in.",
				number: "Voer a.u.b. een getal in.",
				minlength: "Voer a.u.b. minimaal 1 teken in."
			}
		},
		submitHandler: function(form) { 
			form.submit();
		}
	});

    $("#searchShipForm").validate({
        debug: false,
        errorClass: 'alert alert-danger alert-form',
        highlight: function (element, errorClass, validClass) {
            return false;  // ensure this function stops
        },
        unhighlight: function (element, errorClass, validClass) {
            return false;  // ensure this function stops
        },
        //validClass: 'alert alert-success alert-form',
        errorElement: 'div',
        rules: {
            naam: {
                required: false,
                minlength: 2
            },
            minLengte: {
                required: false,
                number: true,
                minlength: 1,
                min: 1
            },
            maxLengte: {
                required: false,
                number: true,
                minlength: 1
            }
        },
        messages: {
            naam: {
                minlength: "Voer a.u.b. minimaal 2 tekens in."
            },
            minLengte: {
                number: "Voer a.u.b. een getal in.",
                minlength: "Voer a.u.b. minimaal 1 teken in.",
                min: "Voer a.u.b. een lengte van minimaal 1 in."
            },
            maxLengte: {
                number: "Voer a.u.b. een getal in.",
                minlength: "Voer a.u.b. minimaal 1 teken in."
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('.formDate').datepicker({
        todayBtn: "linked",
        format: "dd/mm/yyyy",
        language: "nl",
        calendarWeeks: true,
        todayHighlight: true
    });

    $( "#addEntriesToCashBookForm" ).validate({
        debug: false,
        errorClass: 'alert alert-danger alert-form',
        highlight: function (element, errorClass, validClass) {
            return false;  // ensure this function stops
        },
        unhighlight: function (element, errorClass, validClass) {
            return false;  // ensure this function stops
        },
        //validClass: 'alert alert-success alert-form',
        errorElement: 'div',
        rules: {
            amount: {
                number: true
            }
        },
        messages: {
            amount: {
                number: "Voer a.u.b. een geldig bedrag in."
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#addReservationForm #eigenaar").on('change', function() {

        var eigenaarID = $("#eigenaar option:selected").val();
        var data = {'eigenaarID':eigenaarID};

        $.ajax({
            url: './loadMembersShips.php',
            data: data,
            success: function(result) {
                $('#schip').html(result);
                if(result != "") {
                    $('#schip').attr('disabled', false);
                } else {
                    $('#schip').attr('disabled', true);
                }
            }
        });
    });

	$("#menu-toggle").click(function() {

		if($.cookie('menu-toggled') == 'true') {
			$.cookie('menu-toggled', false);
		} else {
			$.cookie('menu-toggled', true);
		}

	});

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

});