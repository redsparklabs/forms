require('./bootstrap');

import Alpine from 'alpinejs';
import ClipboardJS from 'clipboard';

window.Alpine = Alpine;
Alpine.start();

var clipboard = new ClipboardJS('.copy');

clipboard.on('success', function (e) {
    window.$wireui.notify({
        title: 'Form Link!',
        description: 'Form Link Copied saved',
        icon: 'success'
    })
    e.clearSelection();
});
