<script>


  document.addEventListener('DOMContentLoaded', () => {
    const profileButton = document.getElementById('profileButton');
    const profileDropdown = document.getElementById('profileDropdown');

    // Tampilkan/ Sembunyikan dropdown saat tombol diklik
    profileButton.addEventListener('click', (e) => {
      e.stopPropagation(); // Mencegah penutupan langsung
      profileDropdown.classList.toggle('opacity-0');
      profileDropdown.classList.toggle('invisible');
    });

    // Sembunyikan dropdown saat klik di luar
    document.addEventListener('click', () => {
      profileDropdown.classList.add('opacity-0');
      profileDropdown.classList.add('invisible');
    });
  });

    
</script>