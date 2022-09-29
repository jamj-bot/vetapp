@livewireStyles
<link rel="stylesheet" href="/css/admin_custom.css">

<style type="text/css">

    h1 {
        font-size: clamp(1.3rem, 8vw - 1.6rem, 2rem)!important
    }

    .profile-background-gradient {
        background: linear-gradient(180deg, #0C003C 0%, #BFFFAF 100%),
            linear-gradient(165deg, #480045 25%, #E9EAAF 100%),
            linear-gradient(145deg, #480045 25%, #E9EAAF 100%),
            linear-gradient(300deg, rgba(233, 223, 255, 0) 0%, #AF89FF 100%),
            linear-gradient(90deg, #45EBA5 0%, #45EBA5 30%, #21ABA5 30%, #21ABA5 60%, #1D566E 60%, #1D566E 70%, #163A5F 70%, #163A5F 100%);
            background-blend-mode: overlay, overlay, overlay, multiply, normal;
    }

    .profile-background-gradient2 {
        background: radial-gradient(100% 225% at 100% 0%, #FF0000 0%, #000000 100%),
            linear-gradient(236deg, #00C2FF 0%, #000000 100%),
            linear-gradient(135deg, #CDFFEB 0%, #CDFFEB 36%, #009F9D 36%, #009F9D 60%, #07456F 60%, #07456F 67%, #0F0A3C 67%, #0F0A3C 100%);
        background-blend-mode: overlay, hard-light, normal;
    }

    .profile-background-gradient3 {
        background: linear-gradient(123deg, #FFFFFF 0%, #00B2FF 100%),
            linear-gradient(236deg, #BAFF99 0%, #005E64 100%),
            linear-gradient(180deg, #FFFFFF 0%, #002A5A 100%),
            linear-gradient(225deg, #0094FF 20%, #BFF4ED 45%, #280F34 45%, #280F34 70%, #FF004E 70%, #E41655 85%, #B30753 85%, #B30753 100%),
            linear-gradient(135deg, #0E0220 15%, #0E0220 35%, #E40475 35%, #E40475 60%, #48E0E4 60%, #48E0E4 68%, #D7FBF6 68%, #D7FBF6 100%);
        background-blend-mode: overlay, overlay, overlay, darken, normal;
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