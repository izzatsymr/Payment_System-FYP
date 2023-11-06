<!doctype html> <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <head> <meta charset="utf-8"> <meta
    name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>CashlessPaymentSystemm</title>

<!-- Scripts -->
<script src="https://kit.fontawesome.com/e0beef6f9b.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
<script src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js" defer></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
{{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

<!-- Styles -->
{{--
<link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
<link rel="stylesheet" href="https://unpkg.com/ionicons@4.5.10/css/ionicons.min.css">


<!-- Icons -->
<link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">


<!-- Small Ionicons Fixes for AdminLTE -->
<style>
    html {
        background-color: #f4f6f9;
    }

    .nav-icon.icon:before {
        width: 25px;
    }
</style>


@livewireStyles
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed sidebar-collapse">
    <div id="app" class="wrapper">
        <div class="main-header">
            @include('layouts.nav')
        </div>

        @include('layouts.sidebar')

        <main class="content-wrapper p-5">
            @yield('content')
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    @if (session()->has('success'))
    <script>
        var notyf = new Notyf({ dismissible: true })
        notyf.success('{{ session('success') }}')
    </script>
    @endif

    <script>
        /* Simple Alpine Image Viewer */
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageViewer', (src = '') => {
                return {
                    imageUrl: src,

                    refreshUrl() {
                        this.imageUrl = this.$el.getAttribute("image-url")
                    },

                    fileChosen(event) {
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },

                    fileToDataUrl(event, callback) {
                        if (!event.target.files.length) return

                        let file = event.target.files[0],
                            reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }
            })
        })
    </script>

    <!-- Table Sorting -->
    <script>
        $(document).ready(function() {
            // Initialize the sorting direction for each column
            let sortingDirections = {};

            // Add click event listener to each column header
            $('#sortable-table th').click(function() {
                const columnId = $(this).attr('id');

                // Determine the sorting direction
                const currentDirection = sortingDirections[columnId] || 'asc';
                sortingDirections[columnId] = currentDirection === 'asc' ? 'desc' : 'asc';

                // Sort the table
                switch (columnId) {
                    case 'col-amount':
                        sortTableByAmount(sortingDirections[columnId] === 'asc');
                        break;
                    case 'col-time':
                        sortTableByTime(sortingDirections[columnId] === 'asc');
                        break;
                    case 'col-item':
                    case 'col-success':
                    case 'col-cardRFID':
                        sortTableByAlphabetical(sortingDirections[columnId] === 'asc', $(this).index());
                        break;
                }
            });

            // Custom sorting functions for AMOUNT, TIME, ITEM, and SUCCESS columns
            function sortTableByAmount(ascending) {
                const rows = $('#sortable-table tbody tr').get();
                rows.sort(function(a, b) {
                    const aValue = parseFloat($(a).find('td').eq(2).text());
                    const bValue = parseFloat($(b).find('td').eq(2).text());
                    return ascending ? aValue - bValue : bValue - aValue;
                });
                $('#sortable-table tbody').empty().append(rows);
            }

            function sortTableByTime(ascending) {
                const rows = $('#sortable-table tbody tr').get();
                rows.sort(function(a, b) {
                    const aValue = new Date($(a).find('td').eq(4).text());
                    const bValue = new Date($(b).find('td').eq(4).text());
                    return ascending ? aValue - bValue : bValue - aValue;
                });
                $('#sortable-table tbody').empty().append(rows);
            }

            function sortTableByAlphabetical(ascending, column) {
                const rows = $('#sortable-table tbody tr').get();
                rows.sort(function(a, b) {
                    const aValue = $(a).find('td').eq(column).text().toLowerCase();
                    const bValue = $(b).find('td').eq(column).text().toLowerCase();
                    return ascending ? (aValue > bValue ? 1 : -1) : (aValue < bValue ? 1 : -1);
                });
                $('#sortable-table tbody').empty().append(rows);
            }
        });
    </script>
</body>

</html>