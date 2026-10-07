! function() {
    "use strict";

    // Funçao utilitária para inicializar Swipers com segurança
    function initSwiperElements() {
        document.querySelectorAll(".init-swiper").forEach((function(e) {
            let configEl = e.querySelector(".swiper-config");
            if (!configEl) return;

            try {
                let t = JSON.parse(configEl.innerHTML.trim());
                
                // Garante que o Swiper vai encontrar os botões de navegação dentro do contexto dele
                if (t.navigation) {
                    t.navigation.nextEl = e.querySelector(".swiper-button-next");
                    t.navigation.prevEl = e.querySelector(".swiper-button-prev");
                }
                if (t.pagination) {
                    t.pagination.el = e.querySelector(".swiper-pagination");
                }

                if (e.classList.contains("swiper-tab")) {
                    initSwiperWithCustomPagination(e, t);
                } else {
                    new Swiper(e, t);
                }
            } catch (err) {
                console.error("Erro ao parsear JSON do Swiper:", err);
            }
        }));
    }

    // Tenta inicializar quando o DOM estiver pronto
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initSwiperElements);
    } else {
        initSwiperElements();
    }

    let e = document.querySelector("#preloader");
    e && window.addEventListener("load", (() => {
        e.remove()
    }));

    let n = document.querySelector(".scroll-top");
    n && n.addEventListener("click", (e => {
        e.preventDefault(), window.scrollTo({
            top: 0,
            behavior: "smooth"
        })
    }));

    document.addEventListener("scroll", (function() {
        const header = document.getElementById("header");
        if (header) {
            if (window.scrollY > 50) {
                header.classList.add("bg-header");
            } else {
                header.classList.remove("bg-header");
            }
        }
        n && (window.scrollY > 100 ? n.classList.add("active") : n.classList.remove("active"))
    }));

    document.querySelectorAll(".skills-animation").forEach((e => {
        if (typeof Waypoint !== "undefined") {
            new Waypoint({
                element: e,
                offset: "80%",
                handler: function(t) {
                    e.querySelectorAll(".progress .progress-bar").forEach((e => {
                        e.style.width = e.getAttribute("aria-valuenow") + "%"
                    }))
                }
            });
        }
    }));

    document.querySelectorAll(".isotope-layout").forEach((function(e) {
        let o, n = e.getAttribute("data-layout") ?? "masonry",
            i = e.getAttribute("data-default-filter") ?? "*",
            r = e.getAttribute("data-sort") ?? "original-order";
        if (typeof imagesLoaded !== "undefined" && typeof Isotope !== "undefined") {
            imagesLoaded(e.querySelector(".isotope-container"), (function() {
                o = new Isotope(e.querySelector(".isotope-container"), {
                    itemSelector: ".isotope-item",
                    layoutMode: n,
                    filter: i,
                    sortBy: r
                })
            }));
            e.querySelectorAll(".isotope-filters li").forEach((function(n) {
                n.addEventListener("click", (function() {
                    e.querySelector(".isotope-filters .filter-active").classList.remove("filter-active"), this.classList.add("filter-active"), o.arrange({
                        filter: this.getAttribute("data-filter")
                    })
                }), !1)
            }))
        }
    }));

    let i = document.querySelectorAll(".navmenu a");

    function r() {
        i.forEach((e => {
            if (!e.hash) return;
            let t = document.querySelector(e.hash);
            if (!t) return;
            let o = window.scrollY + 200;
            o >= t.offsetTop && o <= t.offsetTop + t.offsetHeight ? (document.querySelectorAll(".navmenu a.active").forEach((e => e.classList.remove("active"))), e.classList.add("active")) : e.classList.remove("active")
        }))
    }
    window.addEventListener("load", r);
    document.addEventListener("scroll", r);

    window.addEventListener("load", (function() {
        document.addEventListener("scroll", (function() {
            let e = document.querySelector(".laptop-parallax");
            if (!e) return;
            let t = document.querySelector(".content-project");
            if (!t) return;
            let o = t.getBoundingClientRect().top;
            if (o < window.innerHeight && o > -t.offsetHeight) {
                let t = .3 * o;
                t = Math.max(-15, Math.min(15, t)), e.style.transform = `translateY(${t}px)`
            }
        }))
    }));

    document.addEventListener("DOMContentLoaded", (function() {
        document.querySelectorAll('a[href^="#"]').forEach((function(e) {
            e.addEventListener("click", (function(evt) {
                if (this.hasAttribute("data-bs-toggle") || this.hasAttribute("data-toggle")) return;

                evt.preventDefault();
                let t = this.getAttribute("href");
                if (t && t.length > 1) {
                    let target = document.querySelector(t);
                    target && window.scrollTo({
                        top: target.offsetTop,
                        behavior: "smooth"
                    })
                } else window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                })
            }))
        }))
    }));

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper !== "undefined") {
            if (document.querySelector('.announcement')) {
                new Swiper('.announcement', {
                    loop: true,
                    speed: 1200,
                    effect: 'fade',
                    fadeEffect: { crossFade: true },
                    autoplay: { delay: 5000, disableOnInteraction: false },
                });
            }
            if (document.querySelector('.announcementVertical')) {
                new Swiper('.announcementVertical', {
                    loop: true,
                    speed: 1200,
                    effect: 'fade',
                    fadeEffect: { crossFade: true },
                    autoplay: { delay: 5000, disableOnInteraction: false },
                });
            }
        }
    });

    if (document.getElementById('socialLinks')) {
        const shareBtn = document.getElementById('shareBtn');
        if (shareBtn) {
            shareBtn.addEventListener('click', function() {
                const links = document.getElementById('socialLinks');
                links.classList.toggle('opacity-0');
            });
        }
    }

    const s = document.getElementById("menu-toggle");
    const a = document.getElementById("menu-mobile");
    const c = document.getElementById("menu-close");

    if (s && a && c) {
        s.addEventListener("click", () => {
            const isActive = a.classList.toggle("active");
            document.body.style.overflow = isActive ? "hidden" : "";
        });

        c.addEventListener("click", () => {
            a.classList.remove("active");
            document.body.style.overflow = "";
        });

        a.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", function(e) {
                const href = this.getAttribute("href");
                if (href && href.startsWith("#")) {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: "smooth" });
                    }
                }
                a.classList.remove("active");
                document.body.style.overflow = "";
            });
        });
    }

    document.querySelectorAll(".phone").forEach(function(phoneInput) {
        phoneInput.addEventListener("input", function(e) {
            let t = e.target.value.replace(/\D/g, "");
            t.length > 11 && (t = t.slice(0, 11));
            t.length > 0 && (t = "(" + t);
            t.length > 3 && (t = t.slice(0, 3) + ") " + t.slice(3));
            t.length > 10 && (t = t.slice(0, 10) + "-" + t.slice(10));
            e.target.value = t;
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const elements = document.querySelectorAll(".animate-on-scroll");
        if (elements.length > 0) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const animation = entry.target.dataset.animation;
                        setTimeout(() => {
                            entry.target.classList.add("animate__animated", animation, "animate__slow");
                        }, 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });

            elements.forEach(el => observer.observe(el));
        }
    });

    window.addEventListener("load", function () {
        const heroSwiperEl = document.querySelector(".hero-swiper");

        if (heroSwiperEl) {
            new Swiper(heroSwiperEl, {
                loop: false,
                effect: "fade",
                speed: 800,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: heroSwiperEl.querySelector(".swiper-pagination"),
                    clickable: true,
                },
                navigation: {
                    nextEl: heroSwiperEl.querySelector(".swiper-button-next"),
                    prevEl: heroSwiperEl.querySelector(".swiper-button-prev"),
                }
            });
        }
    });
}();