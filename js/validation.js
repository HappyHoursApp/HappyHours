$(document).ready(function()
{
    "use strict";
    var preventDefaultEvent = function (e) {
        e.preventDefault();
    };
    // first name validation - blank
    $('#fname').blur(function() {

        var value = $('#fname').val();
        var fname = document.getElementById("fname_form");
        var fnameGlyph = document.getElementById("fname_glyph");

        if (value === "" || value === " ") {
            addError('.valid-first-name', 'First name is required.');
            
            
            // Add has-error bootstrap to div class
            fname.className = "has-error col-xs-12 input-group";
            fnameGlyph.className = "glyphicon form-control-feedback glyphicon-remove";
            
            // remove has-success from div class (if exists)
            fname.removeClass();
            fnameGlyph.removeClass();
            
        }
        else {
            removeError('.valid-first-name', 'First name: ');
            
            fname.className = "has-success col-xs-12 input-group";
            fnameGlyph.className = "glyphicon form-control-feedback glyphicon-ok";
            
            fname.removeClass();
            fnameGlyph.removeClass();
            
             }
        
        // first name validation - character length
        if (value.length > 50) {
            addError('.first-name-character-length', `Character length must'
                        + ' be less than 50 characters`);
        }
        else {
            removeError('.first-name-character-length', `Character length must'
                        + ' be less than 50 characters`);
        }
    });

    // last name validation - blank
    $('#lname').blur(function() {

        var value = $('#lname').val();
        var lname = document.getElementById("lname_form");
        var lnameGlyph = document.getElementById("lname_glyph");
        
        // If field is blank -- error
        if (value === "" || value === " ") {
            addError('.valid-last-name', 'Last name is required.');
            
            // Add has-error bootstrap to div class
            lname.className = "has-error col-xs-12 input-group";
            lnameGlyph.className = "glyphicon form-control-feedback glyphicon-remove";
            
            // remove has-success from div class (if exists)
            lname.removeClass();
            lnameGlyph.removeClass();
        }
        // If field is not blank -- success
        else {
            removeError('.valid-last-name', 'Last name: ');
            
            lname.className = "has-success col-xs-12 input-group";
            lnameGlyph.className = "glyphicon form-control-feedback glyphicon-ok";
            
            lname.removeClass();
            lnameGlyph.removeClass();
        }
        
        // last name validation - character length -- error
        if (value.length > 50) {
            addError('.last-name-character-length', `Character length must'
                     . ' be less than 50 characters`);
            
            // Add has-error bootstrap to div class
            lname.className = "has-error col-xs-12 input-group";
            lnameGlyph.className = "glyphicon form-control-feedback glyphicon-remove";
            
            // remove has-success from div class (if exists)
            lname.removeClass();
            lnameGlyph.removeClass();
        }
        // success
        else {
            removeError('.last-name-character-length', `Character length must'
                     . ' be less than 50 characters`);
            
            lname.className = "has-success col-xs-12 input-group";
            lnameGlyph.className = "glyphicon form-control-feedback glyphicon-ok";
            
            lname.removeClass();
            lnameGlyph.removeClass();
        }
    });

    // school email validation - blank
    $('#school_email').blur(function() {

        var value = $('#school_email').val();
        var schoolemail = document.getElementById("schoolemail_form");
        var schoolemailGlyph = document.getElementById("schoolemail_glyph");
        var flag = validateEmail(value);

        // If field is blank -- error
        if (value === "" || value === " " || !flag) {
            addError('.valid-school-email', 'School email is required.');
            
            // Add has-error bootstrap to div class
            schoolemail.className = "has-error col-xs-12 input-group";
            schoolemailGlyph.className = "glyphicon form-control-feedback glyphicon-remove";
            
            // remove has-success from div class (if exists)
            schoolemail.removeClass();
            schoolemailGlyph.removeClass();
        }
        // If field is not blank -- success
        else {
            removeError('.valid-school email', 'School email: ');
            
            schoolemail.className = "has-success col-xs-12 input-group";
            schoolemailGlyph.className = "glyphicon form-control-feedback glyphicon-ok";
            
            schoolemail.removeClass();
            schoolemailGlyph.removeClass();
        }
        
        // school email validation - character length -- error
        if (value.length > 100) {
            addError('.school-email-character-length', `Character length must'
                     . ' be less than 100 characters`);
            
            // Add has-error bootstrap to div class
            schoolemail.className = "has-error col-xs-12 input-group";
            schoolemailGlyph.className = "glyphicon form-control-feedback glyphicon-remove";
            
            // remove has-success from div class (if exists)
            schoolemail.removeClass();
            schoolemailGlyph.removeClass();
        }
        // success
        else {
            removeError('.school-email-character-length', `Character length must'
                     . ' be less than 100 characters`);
            
            schoolemail.className = "has-success col-xs-12 input-group";
            schoolemailGlyph.className = "glyphicon form-control-feedback glyphicon-ok";
            
            schoolemail.removeClass();
            schoolemailGlyph.removeClass();
        }
    });


    // primary email validation - blank -- error
    $('#primary_email').blur(function() {

        var value = $('#primary_email').val();
        var primeemail = document.getElementById("primeemail_form");
        var primeemailGlyph = document.getElementById("primeemail_glyph");
        var flag = validateEmail(value);

        // If field is blank -- error
        if (value === "" || value === " " || !flag) {
            addError('.valid-prime-email', 'Prime email is required.');
            
            // Add has-error bootstrap to div class
            primeemail.className = "has-error col-xs-12 input-group";
            primeemailGlyph.className = "glyphicon form-control-feedback glyphicon-remove";
            
            // remove has-success from div class (if exists)
            primeemail.removeClass();
            primeemailGlyph.removeClass();
        }
        // If field is not blank -- success
        else {
            removeError('.valid-prime-email', 'Prime email: ');
            
            primeemail.className = "has-success col-xs-12 input-group";
            primeemailGlyph.className = "glyphicon form-control-feedback glyphicon-ok";
            
            primeemail.removeClass();
            primeemailGlyph.removeClass();
        }
        
        // primary email validation - character length -- error
        if (value.length > 100) {
            addError('.prime-email-character-length', `Character length must'
                     . ' be less than 100 characters`);
            
            // Add has-error bootstrap to div class
            primeemail.className = "has-error col-xs-12 input-group";
            primeemailGlyph.className = "glyphicon form-control-feedback glyphicon-remove";
            
            // remove has-success from div class (if exists)
            primeemail.removeClass();
            primeemailGlyph.removeClass();
            
            
        }
        // success
        else {
            removeError('.prime-email-character-length', `Character length must'
                     . ' be less than 100 characters`);
            
            primeemail.className = "has-success col-xs-12 input-group";
            primeemailGlyph.className = "glyphicon form-control-feedback glyphicon-ok";
            
            primeemail.removeClass();
            primeemailGlyph.removeClass();
        }
    });
    
    //$('#twitter').blur(function() {
    //
    //    var value = $('#twitter').val();
    //    var twitter = document.getElementById("twitter_form");
    //    var twitterGlyph = document.getElementById("twitter_glyph");
    //    value = checkHTTP(value);
    //    
    //    (!value.includes("twitter") {
    //        // Add has-error bootstrap to div class
    //        twitter.className = "has-error col-xs-12 input-group";
    //        twitterGlyph.className = "glyphicon form-control-feedback glyphicon-remove";
    //        
    //        // remove has-success from div class (if exists)
    //        twitter.removeClass();
    //        twitterGlyph.removeClass();
    //    }
    //    else {
    //        twitter.className = "has-success col-xs-12 input-group";
    //        twitterGlyph.className = "glyphicon form-control-feedback glyphicon-ok";
    //        
    //        twitter.removeClass();
    //        twitterGlyph.removeClass();
    //    }
    //    
    //}
    
    var flag = 0;
    var check = document.getElementsByName('technologies[]');
    for (var i = 0; i < 5; i++) {
      if(check[i].checked){
        flag ++;
      }
    }
    if (flag < 1 || flag > 4) {
      //alert ("You must only check between one and five boxes!");
      return false;
    }

    // add error message
    function addError(div_id_name, error_message) {

        var input_class = div_id_name + ' input';

        $('form').bind('submit', preventDefaultEvent);
        jQuery(this).parent('div').addClass('has-error');
    }

    // remove error message
    function removeError(div_id_name, ok_message) {

        var input_class = div_id_name + ' input';

        $('form').unbind('submit', preventDefaultEvent);
        $(div_id_name).removeClass("has-error").addClass("has-success");
        $(input_class).removeClass("danger red");
        $(div_id_name + " > span").removeClass("glyphicon-remove").addClass("glyphicon-ok");
        $(div_id_name + " > label").html(ok_message);
    }
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    
    function checkHTTP(value) {
        if (!value.match(/^[a-zA-Z]+:\/\//))
        {
            value = 'http://' + value;
        }
    }
});