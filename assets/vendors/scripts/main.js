$(document).ready(function() {
    // Fermeture automatique des alertes après 4 secondes
    setTimeout(function() {
      $(".alert").alert('close');
    }, 4000);
  });

  // Validation personnalisée Bootstrap
  (function () {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();