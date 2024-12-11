import Echo from 'laravel-echo';
import Reverb from '@laravel/reverb-js';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: process.env.MIX_REVERB_APP_KEY,
    wsHost: process.env.MIX_REVERB_HOST || '127.0.0.1',
    wsPort: process.env.MIX_REVERB_PORT || 8080,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

// Listen for events on the test channel
Echo.channel('test-channel')
    .listen('TestEvent', (e) => {
        console.log('Received message:', e.message);
    });
