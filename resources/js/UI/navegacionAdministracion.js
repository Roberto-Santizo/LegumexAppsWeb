(function () {
    const btnNavManto = document.getElementById("mantenimiento_navegacionBtn");

    if (btnNavManto) {
        btnNavManto.addEventListener("click", function (e) {
            const menuNav = document.getElementById("mantenimiento_navegacion");
            const menuIcon2 = document.getElementById('menuIcon2');
            if (menuNav.classList.contains("hidden")) {
                menuNav.classList.remove("hidden", "slide-out-active2");
                menuNav.classList.add("slide-in2");
                menuNav.classList.add("w-full");
                menuIcon2.classList.remove("rotate-0");
                menuIcon2.classList.add("rotate-90");
              
                setTimeout(() => {
                    menuNav.classList.add("slide-in-active2");
                }, 10);
            } else {
                menuNav.classList.remove("slide-in-active2");
                menuNav.classList.add("slide-out-active2");
                menuIcon2.classList.remove("rotate-90");
                menuIcon2.classList.add("rotate-0");
                menuNav.addEventListener(
                    "transitionend",
                    () => {
                        if (menuNav.classList.contains("slide-out-active2")) {
                            menuNav.classList.add("hidden");
                            menuNav.classList.remove(
                                "slide-in2",
                                "slide-out-active2"
                            );
                        }
                    },
                    { once: true }
                );
            }
        });
    }

    const btnNavAdmin = document.getElementById("administracion_navegacionBtn");

    if (btnNavAdmin) {
        btnNavAdmin.addEventListener("click", function (e) {
            const menuNav2 = document.getElementById("administracion_navegacion");
            const menuIcon2 = document.getElementById('menuIcon3');
            if (menuNav2.classList.contains("hidden")) {
                menuNav2.classList.remove("hidden", "slide-out-active2");
                menuNav2.classList.add("slide-in2");
                menuNav2.classList.add("w-full");
                menuIcon2.classList.remove("rotate-0");
                menuIcon2.classList.add("rotate-90");
              
                setTimeout(() => {
                    menuNav2.classList.add("slide-in-active2");
                }, 10);
            } else {
                menuNav2.classList.remove("slide-in-active2");
                menuNav2.classList.add("slide-out-active2");
                menuIcon2.classList.remove("rotate-90");
                menuIcon2.classList.add("rotate-0");
                menuNav2.addEventListener(
                    "transitionend",
                    () => {
                        if (menuNav2.classList.contains("slide-out-active2")) {
                            menuNav2.classList.add("hidden");
                            menuNav2.classList.remove(
                                "slide-in2",
                                "slide-out-active2"
                            );
                        }
                    },
                    { once: true }
                );
            }
        });
    }
})();
