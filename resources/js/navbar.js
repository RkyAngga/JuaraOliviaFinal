window.onscroll = function () {
    const header = document.querySelector("header");
    const fixedNav = header.offsetTop;
    const menuLinks = document.querySelectorAll("#nav-menu a"); // Menyeleksi semua menu link

    // Menambahkan kelas navbar-fixed jika halaman di-scroll
    if (window.pageYOffset > fixedNav) {
        header.classList.add("navbar-fixed");
    } else {
        header.classList.remove("navbar-fixed");
    }
};

// Untuk menangani active link saat scroll
window.addEventListener("scroll", () => {
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll("#nav-menu a");

    let current = "";
    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        if (pageYOffset >= sectionTop - 100) {
            current = section.getAttribute("id");
        }
    });

    navLinks.forEach((link) => {
        link.classList.remove("active");
        if (link.getAttribute("href") === `#${current}`) {
            link.classList.add("active");
        }
    });
});

// Set active link berdasarkan halaman
function setActiveLink() {
    const currentPath = window.location.hash || window.location.pathname;
    document.querySelectorAll("#nav-menu a").forEach((link) => {
        const linkPath = link.getAttribute("href");
        if (
            linkPath === currentPath ||
            linkPath === "#" + currentPath.split("#")[1]
        ) {
            link.classList.add("active");
            link.setAttribute("aria-current", "page");
        } else {
            link.classList.remove("active");
            link.setAttribute("aria-current", "false");
        }
    });
}

// Panggil saat load dan scroll
window.addEventListener("load", setActiveLink);
window.addEventListener("scroll", setActiveLink);

document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const navMenu = document.getElementById("nav-menu");

    hamburger.addEventListener("click", function () {
        this.classList.toggle("active");
        navMenu.classList.toggle("open");
        navMenu.classList.toggle("hidden");
    });

    // Close menu when clicking on a link (mobile)
    document.querySelectorAll("#nav-menu a").forEach((link) => {
        link.addEventListener("click", function () {
            if (window.innerWidth < 1024) {
                hamburger.classList.remove("active");
                navMenu.classList.remove("open");
                navMenu.classList.add("hidden");
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Profile dropdown functionality
    const profileButton = document.querySelector(".profile-button");
    const profileDropdown = document.querySelector(".profile-dropdown");

    if (profileButton && profileDropdown) {
        profileButton.addEventListener("click", function (e) {
            e.stopPropagation();
            profileDropdown.classList.toggle("hidden");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function () {
            profileDropdown.classList.add("hidden");
        });

        // Prevent dropdown from closing when clicking inside it
        profileDropdown.addEventListener("click", function (e) {
            e.stopPropagation();
        });
    }
});


// ... existing code ...
