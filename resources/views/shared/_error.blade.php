@if(count($errors) > 0)
    <div class="alert alert-danger">
        <div class="mt-2"><b>错误提示：</b></div>
        <ul class="list-unstyled mt-2 mb-2 ml-2">
            @foreach($errors->all() as $error)
                <li><i class="fa fa-info-circle"></i>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif