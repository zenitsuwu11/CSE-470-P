document.addEventListener('DOMContentLoaded', () => {
    const track       = document.querySelector('.carousel-track');
    const leftBtn     = document.querySelector('.left-arrow');
    const rightBtn    = document.querySelector('.right-arrow');
    const cards       = Array.from(track.children);
    const cardsPerPage= 5;
    const totalPages  = Math.ceil(cards.length / cardsPerPage);
    let currentPage   = 0;
  
    const gap = parseInt(getComputedStyle(track).gap) || 0;
    const cardWidth = cards[0]?.getBoundingClientRect().width || 0;
  
    function updateButtons() {
      leftBtn.disabled  = currentPage === 0;
      rightBtn.disabled = currentPage === totalPages - 1;
    }
  
    function moveToPage(page) {
      const offset = page * (cardWidth + gap) * cardsPerPage;
      track.style.transform = `translateX(-${offset}px)`;
      currentPage = page;
      updateButtons();
    }
  
    leftBtn.addEventListener('click', () => {
      if (currentPage > 0) moveToPage(currentPage - 1);
    });
    rightBtn.addEventListener('click', () => {
      if (currentPage < totalPages - 1) moveToPage(currentPage + 1);
    });
  
    updateButtons();
  });
  