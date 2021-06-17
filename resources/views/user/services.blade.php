<x-app-layout>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">WYBIERZ USŁUGĘ</h1>
    </header>
    <div class="container" style="margin-top: 50px">
    <div class="card-deck mb-3 text-center justify-content-center">
        @foreach($services as $service)
            <div class="card mb-4 box-shadow col-md-3 col-lg-3 mb-3">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">{{ $service->name }}</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">{{ $service->price_for_month }}zł<small class="text-muted">/ miesiąc</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>{{ $service->description }}</li>
                        <li><strong>Koszt instalacji - {{ $service->start_price }}zł</strong></li>
                    </ul>
                    <form action="{{ route('potwierdzenie') }}">
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <button type="submit" class="btn btn-lg btn-block btn btn-success">ZAMÓW</button>
                    </form>

                </div>
            </div>
        @endforeach
    </div>
    </div>
</x-app-layout>
