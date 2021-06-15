@extends('layouts.admin')
@section('content')
    <header class="masthead bg-primary text-white text-center" style="padding: 50px">
        <h1 class="masthead-heading mb-0">DODAJ USŁUGĘ</h1>
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

                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Firma:</strong>
                                <select name="company_id" class="form-control">
                                    <option disabled selected>Wybierz firmę</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nazwa:</strong>
                                <input type="text" name="name"  class="form-control" placeholder="Nazwa">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Opis:</strong>
                                <textarea class="form-control" style="height:100px" name="description" placeholder="Opis"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Cena instalacji:</strong>
                                <input type="number" name="start_price" class="form-control" placeholder="Cena startowa">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Miesięczna opłata:</strong>
                                <input type="number" name="price_for_month" class="form-control" placeholder="Miesięczna opłata">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('services.index') }}">COFNIJ</a>
                                <button type="submit" class="btn btn-primary">GOTOWE</button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
