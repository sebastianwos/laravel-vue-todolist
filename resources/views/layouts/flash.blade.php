@if(session()->has('message'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    {{ session('message') }}
                </div>
            </div>
        </div>
    </div>
@endif