var form = document.querySelector('.form');

coriander(form, {
  onChange: true,
  onSubmit: function(data) {
    var formData = new FormData(data.form);
    axios.post(data.form.action, formData);
  }
});
