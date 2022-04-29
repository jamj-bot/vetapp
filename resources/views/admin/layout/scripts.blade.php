@livewireScripts

<script type="text/javascript">
    {{-- Funtion to confirm the deletion of items --}}
    function confirm(id, title, text, model, event) {
        Swal.fire({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.livewire.emit(event, id),
                Swal.fire(
                    'Deleted!',
                     model + ' has been deleted.',
                    'success'
                )
            }
        })
    }

    {{-- Funtion to notify an event --}}
    function notify(event) {
        $(document).Toasts('create', {
            title: event.detail.title,
            subtitle: event.detail.subtitle,
            position: 'topRight',
            class: event.detail.class,
            icon: event.detail.icon,
            autohide: true,
            delay: 10000,
            image: event.detail.image,
            imageAlt: 'User Picture',
            body: event.detail.body
        });
    }
</script>

{{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script> --}}
<script src="//unpkg.com/alpinejs" defer></script>
<!-- The "defer" attribute is important to make sure Alpine waits for Livewire to load first. -->