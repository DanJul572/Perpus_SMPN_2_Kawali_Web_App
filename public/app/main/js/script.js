window.addEventListener('scroll', () => {
    let nav = document.querySelector('nav');
    nav.classList.toggle('sticky', window.scrollY > 0);
});


const menuBtn = document.querySelector('.menu-btn');
const menu = document.querySelector('.menu');
const sidebar = document.querySelector('.sidebar');
const bgSidebar = document.querySelector('.bg-sidebar');
let menuOpen = false;
menuBtn.addEventListener('click', () => {
    if (!menuOpen) {
        menuBtn.classList.add('open');
        sidebar.classList.add('slide');
        bgSidebar.classList.add('bg-slide');
        menuOpen = true;
    } else {
        menuBtn.classList.remove('open');
        sidebar.classList.remove('slide');
        bgSidebar.classList.remove('bg-slide');
        menuOpen = false;
    }
});


// close sidebar
bgSidebar.addEventListener('click', () => {
    menuBtn.classList.remove('open');
    sidebar.classList.remove('slide');
    bgSidebar.classList.remove('bg-slide');
    menuOpen = false;
})


//logout menu
const logout = document.querySelector('.logout');
const logoutMenu = document.querySelector('.logout-menu');

logout.addEventListener('click', () => {
    logoutMenu.classList.toggle('show-menu-log');
});

const logoutPC = document.querySelector('.logout-pc');

logoutPC.addEventListener('click', () => {
    logoutMenu.classList.toggle('show-menu-log');
});


const bgModal = document.querySelectorAll('.bg-modal');
const closeModal = document.querySelectorAll('.click-close-modal');
const actionModal = document.querySelectorAll('.click-action-modal');

actionModal.forEach(action => {
    action.addEventListener('click', function () {
        if (this.id == 'add-modal') {
            bgModal[0].classList.add('show-modal');
        }
        else if (this.id == 'update-modal') {
            bgModal[1].classList.add('show-modal');
        }
        else if (this.id == 'delete-modal') {
            bgModal[2].classList.add('show-modal');

        }
    })
});


//close modal
closeModal.forEach(close => {
    close.addEventListener('click', function () {
        if (this.id == 'close-add-modal') {
            bgModal[0].classList.remove('show-modal');
        }
        else if (this.id == 'btn-close-add-modal') {
            bgModal[0].classList.remove('show-modal');
        }
        else if (this.id == 'close-update-modal') {
            bgModal[1].classList.remove('show-modal');
        }
        else if (this.id == 'btn-close-update-modal') {
            bgModal[1].classList.remove('show-modal');
        }
        else if (this.id == 'close-delete-modal') {
            bgModal[2].classList.remove('show-modal');
        }
        else if (this.id == 'btn-close-delete-modal') {
            bgModal[2].classList.remove('show-modal');
        }
    })
});






// modal siswa



// modal poin



// modal sanksi



// modal pengaduan siswa