<div class="container-fluid">
    {{--to show any kind of error--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{--to show any kind of alerts--}}
    @if(Session::has('message'))
        <?php
        $message = Session::get('message');
        $alert_type = Session::get('alert-type');
        ?>
        @switch($alert_type)
            @case('success')
            <div class="alert alert-success" role="alert">
                {{$message}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @break
            @case('danger')
            <div class="alert alert-danger" role="alert">
                {{$message}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @break
            @case('warning')
            <div class="alert alert-warning" role="alert">
                {{$message}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @break
            @case('error')
                <div class="alert alert-warning" role="alert">
                    {{$message}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @break
            @case('info')
            <div class="alert alert-info" role="alert">
                {{$message}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @break
        @endswitch
    @endif
</div>