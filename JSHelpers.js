/* For CHPUs Inputs */
document.getElementById('title').addEventListener('input', e => {
  const slug = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9а-яё]+/g, '-')
        .replace(/^-+|-+$/g, '');
  document.getElementById('chpu').value = slug;
});
