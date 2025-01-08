<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


<style>


  .fixed-bottom-icon {
    transition: transform 0.3s ease, color 0.3s ease;
  }
  .fixed-bottom-icon:hover {
    transform: scale(1.1); /* Zoom-in saat hover */
  }

  /* Untuk hover dan fallback klik */
.group:hover #profileDropdown {
  opacity: 1;
  visibility: visible;
}

#profileDropdown {
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}





</style>