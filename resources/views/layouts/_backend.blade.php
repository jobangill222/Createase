<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<script>
    function logout() {
        document.getElementById('logout-form').submit();
    }
</script>

<script>

    let toastrConfiguration = {
        // timeOut: 100000,
        positionClass: 'toast-top-center',
    };

    @if($errors->any())
    toastr.error("Please check Errors", 'Oops!', toastrConfiguration)
    @endif

    @if (\Session::has('success'))
    toastr.success("{{\Session::get('success')}}", 'Greet!', toastrConfiguration)
    @endif

    @if (\Session::has('status'))
    toastr.success("{{\Session::get('status')}}", 'Greet!', toastrConfiguration)
    @endif

    @if (\Session::has('error'))
    toastr.error("{{\Session::get('error')}}", 'Oops!', toastrConfiguration)
    @endif

    @if (\Session::has('warning'))
    toastr.warning("{{\Session::get('warning')}}", 'Warning!', toastrConfiguration)
    @endif

    @if (\Session::has('info'))
    toastr.info("{{\Session::get('info')}}", 'Info!', toastrConfiguration)
    @endif

</script>
