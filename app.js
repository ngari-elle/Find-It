document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-confirm]').forEach((element) => {
    element.addEventListener('click', (event) => {
      if (!window.confirm(element.dataset.confirm)) event.preventDefault();
    });
  });

  const photo = document.querySelector('#photo');
  const preview = document.querySelector('#photo-preview');
  if (photo && preview) {
    photo.addEventListener('change', () => {
      const file = photo.files?.[0];
      if (!file) {
        preview.hidden = true;
        return;
      }
      preview.src = URL.createObjectURL(file);
      preview.hidden = false;
    });
  }
});
