document.addEventListener('DOMContentLoaded', () => {

  async function updateCartBadge() {
    try {
      const response = await fetch('get_cart.php');
      const data = await response.json();
      
      let totalItems = 0;
      if (data.success && data.cart) {
      for (let i = 0; i < data.cart.length; i++) {
        totalItems += parseInt(data.cart[i].quantity);
        }
      }
      const badge = document.querySelector('.cart-badge');
      if (badge) {
        badge.textContent = totalItems;
        badge.style.display = totalItems > 0 ? 'flex' : 'none';
      }
    } catch (error) {
      console.error('Error updating cart badge:', error);
    }
  }
  
  window.updateCartBadge = updateCartBadge;
  updateCartBadge();

});

window.initCarousel = function() {
  const carouselWrapper = document.querySelector('.carousel-wrapper');
  
  if (carouselWrapper) { 
    const track = carouselWrapper.querySelector('.carousel-track');
    const slides = Array.from(track.children);
    const nextButton = carouselWrapper.querySelector('.carousel-button-next');
    const prevButton = carouselWrapper.querySelector('.carousel-button-prev');
    let currentSlideIndex = 0;

    const getSlidesToShow = () => {
      if (window.innerWidth >= 1024) return 4;
      if (window.innerWidth >= 768) return 2;
      return 1;
    };

    const getSlideWidth = () => {
      if (slides.length > 0) {
        return slides[0].getBoundingClientRect().width;
      }
      return 0;
    };

    const moveToSlide = (targetIndex) => {
      const slideWidth = getSlideWidth();
      if (slideWidth === 0) return; 

      const amountToMove = slideWidth * targetIndex;
      track.style.transform = `translateX(-${amountToMove}px)`;
      currentSlideIndex = targetIndex;
      updateButtons(targetIndex);
    };

    const updateButtons = (targetIndex) => {
      const slidesToShow = getSlidesToShow();
      const totalSlides = slides.length;

      if (targetIndex === 0) {
        prevButton.classList.add('is-hidden');
      } else {
        prevButton.classList.remove('is-hidden');
      }

      if (targetIndex >= totalSlides - slidesToShow) {
        nextButton.classList.add('is-hidden');
      } else {
        nextButton.classList.remove('is-hidden');
      }
    };

    const newNext = nextButton.cloneNode(true);
    const newPrev = prevButton.cloneNode(true);
    nextButton.parentNode.replaceChild(newNext, nextButton);
    prevButton.parentNode.replaceChild(newPrev, prevButton);

    newNext.addEventListener('click', () => {
      const slidesToShow = getSlidesToShow();
      const totalSlides = slides.length;
      let newIndex = currentSlideIndex + 1;
      if (newIndex > totalSlides - slidesToShow) newIndex = totalSlides - slidesToShow;
      moveToSlide(newIndex);
    });

    newPrev.addEventListener('click', () => {
      let newIndex = currentSlideIndex - 1;
      if (newIndex < 0) newIndex = 0;
      moveToSlide(newIndex);
    });
    window.addEventListener('resize', () => {
      const slideWidth = getSlideWidth();
      track.style.transition = 'none'; 
      track.style.transform = `translateX(-${slideWidth * currentSlideIndex}px)`;
      updateButtons(currentSlideIndex); 
      setTimeout(() => {
        track.style.transition = 'transform 300ms ease-in-out';
      }, 50);
    });
    moveToSlide(0);
  }
};