const btnright = document.querySelector('.icon-right');
const btnleft = document.querySelector('.icon-left');
let count = 0;

function right(re) {

    let product = re.parentElement;
    review = product.getElementsByClassName('review')[0];
    var width = product.querySelector('.item').offsetWidth;
    count += width;
    if (count > width * 3) {
        count = 0;
    }
    review.style.transform = `translateX(${-count}px)`;
};

function left(re) {

    let product = re.parentElement;
    review = product.getElementsByClassName('review')[0];
    var width = product.querySelector('.item').offsetWidth;
    count -= width;
    if (count < 0) {
        count = width * 3;
    }
    review.style.transform = `translateX(${-count}px)`;
};
/* header/ */
var header = document.querySelector('nav');

var fixed = header.offsetTop;
window.onscroll = function() { myFunction() };

function myFunction() {
    if (window.pageYOffset > fixed) {
        header.classList.add("fixed");
    } else {
        header.classList.remove("fixed");
    }
}
function chuyenanh(ad) {
    let b = ad.parentElement.parentElement.parentElement.querySelector('.image img');
    b.src = ad.src;
    console.log(b);
}

let timer;

document.addEventListener('input', e => {
  const el = e.target;
  
  if( el.matches('[data-color]') ) {
    clearTimeout(timer);
    timer = setTimeout(() => {
      document.documentElement.style.setProperty(`--color-${el.dataset.color}`, el.value);
    }, 100)
  }
})

