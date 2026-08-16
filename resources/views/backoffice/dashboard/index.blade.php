@extends('backoffice.backoffice_components.body')

@section('page-title')
Dashboard
@endsection

@section('content')

@endsection


@section("script")
<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });
</script>
@endsection
