{{-- with error --}}
@if (session('error'))
    <div id="alert-container">
        <div class="alert alert-danger alert-dismissible mb-0" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <i class="text-danger" data-feather="alert-circle"></i>
            </div>
            <div class="alert-message">
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif

@if ($errors->any())
    <div id="alert-container">
        <div class="alert alert-primary alert-dismissible mb-0" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <i class="text-primary" data-feather="alert-circle"></i>
            </div>
            <div class="alert-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
