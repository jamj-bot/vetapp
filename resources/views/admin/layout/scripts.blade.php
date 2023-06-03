@livewireScripts

<script type="text/javascript">
    {{-- Funtion to confirm the deletion of items --}}
    // function confirm(id, title, text, model, event) {
    //     Swal.fire({
    //         title: title,
    //         text: text,
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!'
    //     }).then((result) => {
    //         if (result.value) {
    //             window.livewire.emit(event, id),
    //             Swal.fire(
    //                 'Deleted!',
    //                  model + ' has been deleted.',
    //                 'success'
    //             )
    //         }
    //     })
    // }

    {{-- Funtion to notify an event --}}
    function notify(event) {
        $(document).Toasts('create', {
            title: event.detail.title,
            subtitle: event.detail.subtitle,
            position: 'bottomRight',
            class: event.detail.class,
            icon: event.detail.icon,
            autohide: true,
            delay: 10000,
            image: event.detail.image,
            imageAlt: 'User Picture',
            body: event.detail.body
        });
    }

    {{-- Script para marcar como activos o inactivos los rows de las tables --}}
    function updateInterface(id, pageTitle) {
        uncheckAll(pageTitle);
        trActive(id, pageTitle);
        count(pageTitle);
    }

    function uncheckAll(pageTitle) {
        // Desmarca check all si estaba seleccionado al hacer clic en una row
        if (document.getElementById('checkAll' + pageTitle).checked) {
            document.getElementById('checkAll' + pageTitle).checked = false
        }
    }

    function trActive(id, pageTitle) {
        // marca los TR como activados al hacer clic en una row
        var row = document.getElementById("rowcheck" + pageTitle + document.getElementById(id).value)
        row.classList.toggle("table-active")
        row.classList.toggle("text-muted")
    }

    function count(pageTitle) {
        // Cuenta todos los input chechbox que tengan la clase counter+pageTitle y su estado sea 'checked'
        var checkedItems = document.querySelectorAll('input[type="checkbox"]:checked.counter' + pageTitle).length;

        if (checkedItems < 1) {
            document.getElementById("destroyMultiple" + pageTitle).classList.add("d-none"); // oculta el botton de eliminar
            document.getElementById("dynamicText" + pageTitle).innerHTML =  pageTitle; // Muestra el título de la página
        }
        if (checkedItems > 0) {
            document.getElementById("destroyMultiple"  + pageTitle).classList.remove("d-none"); // muestra el botton eliminar
            document.getElementById("dynamicText"  + pageTitle).innerHTML = checkedItems + ' item(s) selected'; // Muestra el n° de elementos
        }

        // Bloque que solo se usa en los dumpster o recycle bin para el botón Restore Multiple
        if (document.querySelector("#restoreMultiple" + pageTitle)) {
            if (checkedItems < 1) {
                document.getElementById("restoreMultiple" + pageTitle).classList.add("d-none"); // oculta
            }
            if (checkedItems > 0) {
                document.getElementById("restoreMultiple"  + pageTitle).classList.remove("d-none"); // muestra
            }
        }
    }
</script>

{{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script> --}}
<script src="//unpkg.com/alpinejs" defer></script>
<!-- The "defer" attribute is important to make sure Alpine waits for Livewire to load first. -->

<!-- Select2-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>