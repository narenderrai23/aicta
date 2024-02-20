<!-- Bootstrap Css -->
<link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- choices css -->
<link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- alertifyjs Css -->
<link href="../assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />
<!-- alertifyjs default themes  Css -->
<link href="../assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />

<!-- Sweet Alert-->
<link href="../assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<style>
    .is-selected {
        background-color: #f0f0f0;
    }

    .table {
        font-size: 11px;
    }

    .asterisk {
        color: #dc3545;
    }

    [type="number"]::-webkit-inner-spin-button,
    [type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .headinginfo {
        /* background-color: #003032; */
        background-color: #780909;
           color: #fff;
               font-size: larger;
    }

    .select2 {
        text-transform: capitalize;
    }

    .select2-container--default.select2-container--disabled .select2-selection--single,
    .select2-container--default .select2-selection--single {
        background-color: transparent;
        border: 0;
        border-radius: 0;
    }

    .select2-selection__arrow {
        height: 30px !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        width: 105px;
        padding: 0;
    }

    [type="number"]::-webkit-inner-spin-button,
    [type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .dt-buttons {
        position: absolute;
        /* bottom: 21px; */
    }

    @keyframes dtb-spinner {
        100% {
            transform: rotate(360deg)
        }
    }

    @-o-keyframes dtb-spinner {
        100% {
            -o-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    @-ms-keyframes dtb-spinner {
        100% {
            -ms-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    @-webkit-keyframes dtb-spinner {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    @-moz-keyframes dtb-spinner {
        100% {
            -moz-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    div.dt-button-collection {
        position: absolute;
        top: 0;
        left: 0;
        width: 200px;
        margin-top: 3px;
        margin-bottom: 3px;
        padding: .75em 0;
        border: 1px solid rgba(0, 0, 0, 0.4);
        background-color: white;
        overflow: hidden;
        z-index: 2002;
        border-radius: 5px;
        box-shadow: 3px 4px 10px 1px rgba(0, 0, 0, 0.3);
        box-sizing: border-box
    }

    div.dt-button-collection .dt-button {
        position: relative;
        left: 0;
        right: 0;
        width: 100%;
        display: block;
        float: none;
        background: none;
        margin: 0;
        padding: .5em 1em;
        border: none;
        text-align: left;
        cursor: pointer;
        color: inherit
    }


    div.dt-button-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        background: radial-gradient(ellipse farthest-corner at center, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        z-index: 2001
    }

    .dt-button.processing {
        color: rgba(0, 0, 0, 0.2)
    }

    .dt-button-collection button:not(.dt-button-active) {
        background-color: darkcyan !important;
        color: white !important;
    }

    tr code {
        font-family: var(--bs-body-font-family);
        cursor: pointer;
        font-size: 12px;
    }
</style>