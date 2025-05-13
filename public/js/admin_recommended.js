document.addEventListener('DOMContentLoaded', function () {
    const gameSelect = document.getElementById('news_game_id');
    const imageLinkInput = document.getElementById('image_link');
  
    gameSelect.addEventListener('change', function () {
      const selectedOption = this.options[this.selectedIndex];
      const imageUrl = selectedOption.getAttribute('data-image');
      if (imageUrl) {
        imageLinkInput.value = imageUrl;
      } else {
        imageLinkInput.value = '';
      }
    });
  });
  