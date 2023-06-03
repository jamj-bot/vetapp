@livewireStyles
<link rel="stylesheet" href="/css/admin_custom.css">

{{-- Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css"> --}}


<style type="text/css">

    h1 {
        font-size: clamp(1.3rem, 8vw - 1.6rem, 2rem)!important
    }



    .select2-selection__choice__display {
        color: #212529;
    }

    .select2-results__options {
        background-color: white;
        color: #212529;
    }

.select2-results__option--selectable {
    background-color: white;
    color: #212529;
}


/* .select2-results__option--selected {
    background-color: purple;
    color: white;
}

.select2-results__option--highlighted {
    background-color: green;
    color: white;
}*/


/*    Muestra los iconos de las tablas al hacer hover en el tr*/
    .datatable tr .icon {
        visibility: hidden;
    }

    .datatable tr:hover .icon {
        visibility: visible;
    }

/*    .loader{
        display: block;
        position: relative;
        height: 32px;
        width: 140px;
        border: 3px solid #ced4da;
        border-radius: 20px;
        box-sizing: border-box;
    }

    .loader:before{
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #077fff;
        animation: ballbns 2s ease-in-out infinite alternate;
    }

    @keyframes ballbns {
        0% {  left: 0; transform: translateX(0%); }
        100% {  left: 100%; transform: translateX(-100%); }
    }
*/

    .loader {
        width: 48px;
        height: 48px;
        background: #899097;
        display: inline-block;
        border-radius: 50%;
        box-sizing: border-box;
        animation: animloader 0.75s ease-in infinite;
        }

    @keyframes animloader {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(1);
            opacity: 0;
        }
    }



/* From uiverse.io */
/*button {
 width: 150px;
 height: 50px;
 cursor: pointer;
 display: flex;
 align-items: center;
 background: red;
 border: none;
 border-radius: 5px;
 box-shadow: 1px 1px 3px rgba(0,0,0,0.15);
 background: #e62222;
}

button, button span {
 transition: 200ms;
}

button .text {
 transform: translateX(35px);
 color: white;
 font-weight: bold;
}

button .icon {
 position: absolute;
 border-left: 1px solid #c41b1b;
 transform: translateX(110px);
 height: 40px;
 width: 40px;
 display: flex;
 align-items: center;
 justify-content: center;
}

button svg {
 width: 15px;
 fill: #eee;
}

button:hover {
 background: #ff3636;
}

button:hover .text {
 color: transparent;
}

button:hover .icon {
 width: 150px;
 border-left: none;
 transform: translateX(0);
}

button:focus {
 outline: none;
}

button:active .icon svg {
 transform: scale(0.8);
}
*/

/* From uiverse.io by @mrhyddenn  button delete*/
.my-button {
    background: none;
    border: none;
    padding: 10px 10px;
    border-radius: 10px;
}

.my-button:hover {
    background: rgba(170, 170, 170, 0.062);
    transition: 0.5s;
}

.my-button svg {
    color: #6361d9;
}




/* From uiverse.io by @mrhyddenn  button red delete*/
.button2 {
    width: 155px;
    height: 50px;
    cursor: pointer;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    background: red;
    border: none;
    border-radius: 5px;
    -webkit-box-shadow: 1px 1px 3px rgba(0,0,0,0.15);
            box-shadow: 1px 1px 3px rgba(0,0,0,0.15);
    background: #e62222;
}

.button2, .button2 span {
    -webkit-transition: 1000ms;
            transition: 1000ms;
}

.button2 .text {
    -webkit-transform: translateX(35px);
        -ms-transform: translateX(35px);
            transform: translateX(35px);
    color: white;
    /* font-weight: bold;*/
}

.button2 .icon {
    position: absolute;
    /*border-left: 1px solid #c41b1b;*/
    -webkit-transform: translateX(110px);
        -ms-transform: translateX(110px);
            transform: translateX(110px);
    height: 40px;
    width: 40px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.button2 svg {
    width: 15px;
    fill: #eee;
}

.button2:hover {
    background: #ff3636;
}

.button2:hover .text {
    color: transparent;
}

.button2:hover .icon {
    width: 150px;
    border-left: none;
    -webkit-transform: translateX(0);
        -ms-transform: translateX(0);
            transform: translateX(0);
}

.button2:focus {
 outline: none;
}

.button2:active .icon svg {
 -webkit-transform: scale(0.8);
     -ms-transform: scale(0.8);
         transform: scale(0.8);
}


</style>