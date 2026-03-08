{
    const installButtons = document.querySelectorAll('.ztk-install-plugin-btn');

    installButtons.forEach((button) =>{
        const spinner = button.parentElement.querySelector('.ztk-install-plugin-spn')
        button.addEventListener('click', () => {
            const pluginSlug = button.getAttribute('data-slug');
            spinner.classList.add('is-active');
            fetch(ajaxurl,{
                method: 'POST',
                headers:{
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                 body: new URLSearchParams({
                    action: 'zkt_plugin_install',
                    slug: pluginSlug,
                 })
            })
            .then(res => res.json())
            .then(data => {
                spinner.classList.remove('is-active');
    
                const noticeType = data.success ? 'success' : 'error';
                const notice = `
                    <div class="notice notice-${noticeType} is-dismissible">
                        <p>${data.data}</p>
                    </div>
                `;
                button.parentElement.insertAdjacentHTML('afterEnd', notice);
            })
        });
    } );
}
