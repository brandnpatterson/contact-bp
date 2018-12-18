var form = document.querySelector('.form');
var mailerAlert = document.querySelector('.mailer-alert');
var mailerCheck = document.querySelector('.mailer-check');

function showMessage(message) {
  mailerAlert.querySelector('p').textContent = message;
}

coriander(form, {
  onChange: true,
  onSubmit: function(data) {
    var formData = new FormData(data.form);

    axios
      .post(data.form.action, formData)
      .then(function(res) {
        mailerAlert.classList.add('alert-success');
        mailerCheck.classList.remove('hidden');

        showMessage(res.data.message);
      })
      .catch(function(err) {
        mailerAlert.classList.add('alert-success');
        mailerCheck.classList.remove('hidden');

        if (err.data.message) {
          showMessage(err.data.message);
        } else {
          showMessage('Your email was not sent');
        }
      })
      .then(function() {
        window.scrollTo(0, 0);
      });
  }
});
