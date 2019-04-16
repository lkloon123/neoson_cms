import {pleaseWait} from 'please-wait';
import Typed from 'typed.js';

import 'please-wait/build/please-wait.css';
import '@css/bootscript.scss';

window.loading_screen = pleaseWait({
    logo: "/images/text_logo.png",
    backgroundColor: '#f46d3b',
    loadingHtml: '<span id="typed" class=loading-message></span><div class="half-circle-spinner"><div class="circle circle-1"></div><div class="circle circle-2"></div></div>'
});

new Typed('#typed', {
    strings: ['Booting System...', 'Loading Scripts...', 'Fetching Data From Server...', 'Loading Settings...', 'Building Pages...'],
    typeSpeed: 60,
    backSpeed: 60,
    startDelay: 700,
    loop: true
});
