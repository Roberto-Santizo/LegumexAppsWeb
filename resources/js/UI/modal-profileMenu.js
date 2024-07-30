(function(){
    const btnProfile = document.getElementById('btnProfile');
    var modal = document.getElementById('profileModal');
    var header = document.querySelector('.header');
    var closeModalBtn = document.getElementById('close-btn');

    if(btnProfile){
        btnProfile.onclick = function(){     
            modal.classList.toggle('hidden');
            modal.classList.toggle('block');
        };

        closeModalBtn.onclick = function() {
            modal.classList.toggle('hidden');
            modal.classList.toggle('block');
        };
    }
})();