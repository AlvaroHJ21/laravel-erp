<!-- Imagen Modal-->
<div class="modal fade" id="modal-imagen" tabindex="-1" aria-labelledby="modal-imagen-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg justify-content-center">
    <div class="modal-content" style="width: 500px;">
      <img id="image-preview" src="" alt="" width="">
    </div>
  </div>
</div>

<script>
  const images = document.querySelectorAll('.img-thumbnail');
  images.forEach(image => {
    image.addEventListener('click', () => {
      const img = document.getElementById('image-preview');
      img.src = image.src;
    });
  });
</script>
