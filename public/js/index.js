var form = document.querySelector('.form');
var mailerAlert = document.querySelector('.mailer-alert');
var mailerCheck = document.querySelector('.mailer-check');

coriander(form, {
  onChange: true,
  onSubmit: function(data) {
    var formData = new FormData(data.form);
    axios
      .post(data.form.action, formData)
      .then(function(res) {
        mailerAlert.classList.add('alert-success');
        mailerAlert.querySelector('p').textContent = res.data.message;
        mailerCheck.classList.remove('hidden');
      })
      .catch(function(err) {
        mailerAlert.classList.add('alert-success');
        mailerAlert.querySelector('p').textContent = err.data.message;
        mailerCheck.classList.remove('hidden');
      });
  }
});
