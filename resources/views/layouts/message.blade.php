<script>
            @if(\Session::has('message'))
    var message = "{{ \Session::get('message') }}";
    var title = "{{ \Session::get('title') }}";
    var type = "{{ \Session::get('type') }}";
            swal({
                type: type,
                title: title,
                text: message
            });
    @endif
</script>