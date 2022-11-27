/* Animation when scrolling */ 

function reveal() {
    var reveals = document.querySelectorAll(".reveal");
  
    for (var i = 0; i < reveals.length; i++) {
      var windowHeight = window.innerHeight;
      var elementTop = reveals[i].getBoundingClientRect().top;
      var elementVisible = 150;
  
      if (elementTop < windowHeight - elementVisible) {
        reveals[i].classList.add("active2");
      } else {
        reveals[i].classList.remove("active2");
      }
    }
  }
  
  window.addEventListener("scroll", reveal);