
$(document).Toasts('create', {
    title: event.detail.title,
    subtitle: event.detail.subtitle,
    position: 'topRight',
    class: event.detail.class,
    icon: event.detail.icon,
    autohide: true,
    delay: 8000,
    image: event.detail.image,
    imageAlt: 'User Picture',
    body: event.detail.body
});