@extends('layouts.admin')
@section('content')
    <header class="masthead bg-primary text-white text-center" style="padding: 50px">
        <h1 class="masthead-heading mb-0">EDYTUJ USŁUGĘ</h1>
    </header>
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row justify-content-center">
                <div class="row">
                    <div class="col-lg-12 margin-tb">

                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Błąd!</strong> Wystąpił błąd, sprawdź poprawność wpisanych danych<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('services.update', $service->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nazwa:</strong>
                                <input type="text" name="name"  value="{{ $service->name }}" class="form-control" placeholder="Nazwa">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Opis:</strong>
                                <textarea class="form-control" style="height:100px" name="description" placeholder="Opis">{{ $service->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Cena instalacji:</strong>
                                <input type="number" name="start_price" class="form-control" value="{{ $service->start_price }}" placeholder="Cena startowa">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Miesięczna opłata:</strong>
                                <input type="number" name="price_for_month" value="{{ $service->price_for_month }}" class="form-control" placeholder="Miesięczna opłata">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('services.index') }}">COFNIJ</a>
                                <button type="submit" class="btn btn-primary">ZAPISZ ZMIANY</button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
