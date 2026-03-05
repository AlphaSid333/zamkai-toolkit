{
    const installButtons = document.querySelectorAll('.ztk-install-plugin-btn');

    installButtons.forEach((button) =>{
        button.addEventListener('click', () => {
            const spinner = button.parentElement.querySelector('.ztk-install-plugin-spn')
            spinner.classList.add('is-active');
        });
    } );
}
