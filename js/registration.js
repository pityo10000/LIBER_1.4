
  $(document).ready(function() {

    $('input[name=\"email\"]').change(function() {
      var input = $(this).val();
      var regex = new RegExp(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i);
      var error = '';
      if(!input){
        error = 'E-mail cím mező nem lehet üres!';
      } else if (!input.match(regex)) {
        error = 'Hibás e-mail cím!';
      } else {
        error = '';
      }

      $('#email_error').text(error);
    });

    $('input[name=\"password\"]').change(function() {
      var input = $(this).val();
      var regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
      var error = '';
      if(!input){
        error = 'Jelszó mező nem lehet üres!';
      } else if (!input.match(regex)) {
        error = 'Hibás jelszó!';
      } else {
        error = '';
      }

      $('#password_error').text(error);
    });

    $('input[name=\"passwordConfirm\"]').change(function() {
      var input = $(this).val();
      var regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
      var error = '';
      if(!input){
        error = 'Jelszó megerősítése mező nem lehet üres!';
      } else if (!input.match(regex)) {
        error = 'Hibás jelszó!';
      } else {
        error = '';
      }

      $('#passwordConfirm_error').text(error);
    });

    $('input[name=\"phoneNumber\"]').change(function() {
      var input = $(this).val();
      var regex = new RegExp(/^[0-9\-\+]{9,15}$/);
      var error = '';
      if(!input){
        error = 'Telefonszám mező nem lehet üres!';
      } else if (!input.match(regex)) {
        error = 'Hibás telefonszám!';
      } else {
        error = '';
      }

      $('#phoneNumber_error').text(error);
    });

    $('input[name=\"taxNumber\"]').change(function() {
      var input = $(this).val();
      var regex = new RegExp(/^(\d{7})(\d)\-([1-5])\-(0[2-9]|[13][0-9]|2[02-9]|4[0-4]|51)$/);
      var error = '';
      if(!input){
        error = 'Adószám mező nem lehet üres!';
      } else if (!input.match(regex)) {
        error = 'Hibás Adószám!';
      } else {
        error = '';
      }

      $('#taxNumber_error').text(error);
    });
  });
