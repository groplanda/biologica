import Timer from './module/Timer';
import Modals from './module/Modals';
import Menu from './module/Menu';
import { CountUp } from 'countup.js';
import Confirm from './module/Confirm';
import $ from 'jquery';
window.jQuery = $;
require("@fancyapps/fancybox");
require('slick-carousel');

window.addEventListener('DOMContentLoaded', () => {
  const counter = document.querySelector('.counter'),
        toUp = document.querySelector('.to-top'),
        menuItems = document.querySelectorAll('.popup-draweler__nav-link'),
        rewiewAvatars = document.querySelectorAll('.rewiews__avatar__list__item'),
        comments = document.querySelectorAll('.rewiews__text__comment');
  try {
    Timer('.timer', '2020-12-27');
  } catch {}
  Modals();
  Menu();
  Confirm();
  $('.slider-home').slick({
    dots: true,
    infinite: true,
  });

  $('.fancybox').fancybox();
  $('[data-fancybox="gallery"]').fancybox();

  $('form').on('ajaxSuccess', function(event) {
    event.currentTarget.reset();
  });
  $(window).on('ajaxInvalidField', function(event, fieldElement, fieldName, errorMsg, isFirst) {
    $(fieldElement).closest('.form-group').addClass('has-error');
  });

  $(document).on('ajaxPromise', '[data-request]', function() {
    $(this).closest('form').find('.form-group.has-error').removeClass('has-error');
  });

  const CountUpOptions = {
    duration: 5,
    decimal: '',
  }

  const counYear = new CountUp(document.querySelector('.counter__year'), 15, CountUpOptions);
  const counTeacher = new CountUp(document.querySelector('.counter__teacher'), 2, CountUpOptions);
  const counLearning = new CountUp(document.querySelector('.counter__learning'), 2, CountUpOptions);
  const counGraduate = new CountUp(document.querySelector('.counter__graduate'), 824, CountUpOptions);

  function offsetPosition(element) {
    let offsetLeft = 0, offsetTop = 0;
    do {
      offsetLeft += element.offsetLeft;
      offsetTop  += element.offsetTop;
    } while (element = element.offsetParent);
      return [offsetLeft, offsetTop];
  }

  window.addEventListener('scroll', () => {
    if(counter) {
      if(pageYOffset >= offsetPosition(counter)[1] - 300) {
        counYear.start();
        counTeacher.start();
        counLearning.start();
        counGraduate.start();
      }
    }

    if(pageYOffset > 300) {
      toUp.style.display = 'flex';
      toUp.classList.remove('animate__zoomOut');
      toUp.classList.add('animate__zoomInUp');
    } else {
      toUp.classList.remove('animate__zoomInUp');
      toUp.classList.add('animate__zoomOut');
      setTimeout(() => {
        toUp.style.display = 'none';
      }, 400)
    }
  })

  toUp.addEventListener('click', e => {
    e.preventDefault();
    document.body.scrollIntoView({behavior: "smooth"});
  })

  menuItems.forEach(item => {
    item.addEventListener('click', (e) => {
      const target = e.target;
      if(target && target.classList.contains('open')) {
        e.preventDefault();
        let next = target.parentNode.nextElementSibling;
        if(next && next.classList.contains('dropdown')) {
          if(next.classList.contains('animate__fadeInLeft')) {
            target.classList.remove('fa-minus');
            target.classList.add('fa-plus');
            next.classList.add('animate__fadeOut');
            next.classList.remove('animate__fadeInLeft');
            setTimeout(() => next.style.display = 'none', 500)
          } else {
            target.classList.remove('fa-plus');
            target.classList.add('fa-minus');
            next.classList.remove('animate__fadeOut');
            next.style.display = 'block';
            next.classList.add('animate__fadeInLeft');
          }
        }
      }
    })
  })

  rewiewAvatars.forEach(avatar => {
    avatar.addEventListener('click', () => {
      rewiewAvatars.forEach(item => item.classList.remove('active'));
      avatar.classList.add('active');
      let currentComment = avatar.dataset.page;
      comments.forEach(comment => {
        comment.classList.remove('animate__zoomIn');
        comment.classList.remove('active');
        if(comment.classList.contains(`page-${currentComment}`)) {
          comment.classList.add('active');
          comment.classList.add('animate__zoomIn');
        }
      })
    })
  })
})

window.onload = () => {
  document.body.classList.remove('modal-open');
  let loader = document.querySelector('.loader');
  loader.classList.add('animate__fadeOut');
  setTimeout(() => {
    loader.style.display = 'none';
  }, 500)
}