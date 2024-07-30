(function(){
    const btnMenuMobile = document.getElementById('btnMenuMobile');

    if (btnMenuMobile) {
        const accountBtn = document.getElementById('menuMobile_account');
        btnMenuMobile.addEventListener('click', function(e) {
            const menuNav = document.getElementById('menu-nav');
            
            if (menuNav.classList.contains('hidden')) {
                menuNav.classList.remove('hidden', 'slide-out-active');
                menuNav.classList.add('slide-in');
                menuNav.classList.add('w-full');
                setTimeout(() => {
                    menuNav.classList.add('slide-in-active');
                }, 10);
            } else {
                menuNav.classList.remove('slide-in-active');
                menuNav.classList.add('slide-out-active');
                menuNav.addEventListener('transitionend', () => {
                    if (menuNav.classList.contains('slide-out-active')) {
                        menuNav.classList.add('hidden');
                        menuNav.classList.remove('slide-in', 'slide-out-active');
                    }
                }, { once: true });
            }
        });

        accountBtn.addEventListener('click',function(){
                const accountContent = document.getElementById('accountContent');
                const menuIcon = document.getElementById('menuIcon');
                // Toggle the menu visibility
                accountContent.classList.toggle('hidden');
                
            // Toggle the icon class
            if (accountContent.classList.contains('hidden')) {
                menuIcon.classList.remove('rotate-90');
                menuIcon.classList.add('rotate-0');
            } else {
                menuIcon.classList.remove('rotate-0');
                menuIcon.classList.add('rotate-90');
            }
        })
    }
})();