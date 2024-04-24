import './bootstrap';

console.log(Pusher);
console.log(Echo);

Echo.channel('ping-channel')
    .listen('.ping-alias', (e) => {
        console.log('pong!');
        console.log({e});
    });
