(function () {
  "use strict";

  /* ==========================
     SCROLL SUAVE (ÂNCORAS)
  ========================== */
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener("click", function (e) {
        const targetId = this.getAttribute("href");

        if (targetId && targetId.length > 1) {
          const target = document.querySelector(targetId);
          if (target) {
            e.preventDefault();
            window.scrollTo({
              top: target.offsetTop,
              behavior: "smooth",
            });
          }
        } else {
          e.preventDefault();
          window.scrollTo({
            top: 0,
            behavior: "smooth",
          });
        }
      });
    });
  });

  /* ==========================
     BOTÃO VOLTAR AO TOPO
  ========================== */
  const scrollTopBtn = document.querySelector(".scroll-top");

  if (scrollTopBtn) {
    scrollTopBtn.addEventListener("click", function (e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });

    document.addEventListener("scroll", function () {
      window.scrollY > 100
        ? scrollTopBtn.classList.add("active")
        : scrollTopBtn.classList.remove("active");
    });
  }

  /* ==========================
     SWIPER – MAIN
  ========================== */
  document.addEventListener("DOMContentLoaded", function () {
    const mainSwiperEl = document.querySelector(".main-swiper");

    if (!mainSwiperEl || typeof Swiper === "undefined") return;

    const mainSwiper = new Swiper(".main-swiper", {
      loop: true,
      speed: 700,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination.news",
        clickable: true,
        type: "bullets",
      },
      keyboard: {
        enabled: true,
      },
      effect: "slide",
      breakpoints: {
        0: { speed: 500 },
        768: { speed: 700 },
      },
    });

    mainSwiperEl.addEventListener("mouseenter", () => {
      if (mainSwiper.autoplay) mainSwiper.autoplay.stop();
    });

    mainSwiperEl.addEventListener("mouseleave", () => {
      if (mainSwiper.autoplay) mainSwiper.autoplay.start();
    });
  });

  /* ==========================
     CONTADOR DE DIFERENCIAIS
  ========================== */
  document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll(".stat-number");
    const statsSection = document.querySelector(".stats-section");

    if (!counters.length || !statsSection) return;

    let started = false;

    const animateCounters = () => {
      if (started) return;
      started = true;

      counters.forEach(counter => {
        const target = Number(counter.dataset.target) || 0;
        const duration = 1500;
        const startTime = performance.now();

        const update = (currentTime) => {
          const progress = Math.min(
            (currentTime - startTime) / duration,
            1
          );

          counter.textContent = Math.floor(progress * target);

          if (progress < 1) {
            requestAnimationFrame(update);
          } else {
            counter.textContent = target + "+";
          }
        };

        requestAnimationFrame(update);
      });
    };

    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCounters();
          observer.disconnect();
        }
      });
    }, { threshold: 0.4 });

    observer.observe(statsSection);
  });

  /* ==========================
     BOTÃO SHARE
  ========================== */
  const socialLinks = document.getElementById("socialLinks");
  const shareBtn = document.getElementById("shareBtn");

  if (socialLinks && shareBtn) {
    shareBtn.addEventListener("click", function () {
      socialLinks.classList.toggle("opacity-0");
    });
  }

  /* ==========================
     SEARCH INPUT
  ========================== */
  const searchIcon = document.querySelector(".search-icon");

  if (searchIcon) {
    searchIcon.addEventListener("click", function () {
      const wrapper = this.closest(".search-wrapper");
      if (!wrapper) return;

      wrapper.classList.toggle("active");

      const input = wrapper.querySelector(".search-input");
      if (input && wrapper.classList.contains("active")) {
        input.focus();
      }
    });
  }

  /* ==========================
     SWIPER – GALERIA COM THUMBS
  ========================== */
  window.addEventListener("load", function () {
    const thumbsEl = document.querySelector(".gallery-thumbs");
    const topEl = document.querySelector(".gallery-top");

    if (!thumbsEl || !topEl || typeof Swiper === "undefined") return;

    const thumbsSwiper = new Swiper(".gallery-thumbs", {
      spaceBetween: 0,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
      slideToClickedSlide: true,
      loopedSlides: 7,
      breakpoints: {
        360: { slidesPerView: 2.2 },
        680: { slidesPerView: 4 },
        768: { slidesPerView: 4 },
        1024: { slidesPerView: 4 },
      },
    });

    new Swiper(".gallery-top", {
      spaceBetween: 0,
      loop: true,
      loopedSlides: 7,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      thumbs: {
        swiper: thumbsSwiper,
      },
    });
  });

})();
