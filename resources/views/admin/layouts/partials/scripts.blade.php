<!-- General JS Scripts -->
<script src="{{ asset("") }}admin/assets/modules/jquery.min.js"></script>
<script src="{{ asset("") }}admin/assets/modules/popper.js"></script>
<script src="{{ asset("") }}admin/assets/modules/tooltip.js"></script>
<script src="{{ asset("") }}admin/assets/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset("") }}admin/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="{{ asset("") }}admin/assets/modules/moment.min.js"></script>
<script src="{{ asset("") }}admin/assets/js/stisla.js"></script>

<!-- JS Libraies -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset("") }}admin/assets/modules/summernote/summernote-bs4.js"></script>
<script src="{{ asset("") }}admin/assets/modules/codemirror/lib/codemirror.js"></script>
<script src="{{ asset("") }}admin/assets/modules/codemirror/mode/javascript/javascript.js"></script>
<script src="{{ asset("") }}admin/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

<script src="{{ asset("") }}admin/assets/modules/datatables/datatables.min.js"></script>
<script src="{{ asset("") }}admin/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset("") }}admin/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="{{ asset("") }}admin/assets/modules/jquery-ui/jquery-ui.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset("") }}admin/assets/js/page/modules-datatables.js"></script>


<!-- Template JS File -->
<script src="{{ asset("") }}admin/assets/js/scripts.js"></script>
<script src="{{ asset("") }}admin/assets/js/custom.js"></script>
<script>
  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"

    switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break;
  }
@endif
</script>
@yield('js')