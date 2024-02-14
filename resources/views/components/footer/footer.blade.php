<footer class="footer">
    <div class="container-fluid">
        <div class="row text-muted">
            <div class="col-6 text-start">
                <p class="mb-0">
                    <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>MiniERP</strong></a> &copy;
                    Pmbh {{ date('Y') }} | Page rendered in {{ number_format(microtime(true) - LARAVEL_START, 3) }}
                    seconds | Environment:
                    {{ ucfirst(env('ENVIRONMENT')) }}
                </p>
            </div>
        </div>
    </div>
</footer>
