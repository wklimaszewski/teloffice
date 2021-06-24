@extends('layouts.admin')
@section('content')
    <header class="masthead bg-primary text-white text-center" style="padding: 50px">
        <h1 class="masthead-heading mb-0">EDYTUJ UMOWĘ</h1>
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

                <form action="{{ route('agreements.update',$agreement->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Czas trwania:</strong>
                                <input type="text" name="name" value="{{ $agreement->duration }}" class="form-control" placeholder="Czas trwania">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Cena początkowa:</strong>
                                <input type="number" class="form-control" name="description" placeholder="Cena początkowa" value="{{ $agreement->start_price }}">
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Cena miesiączna:</strong>
                                <input type="number" name="address" value="{{ $agreement->price_for_month }}" class="form-control" placeholder="Cena miesiączna">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('agreements.index') }}"> COFNIJ</a>
                                <button type="submit" class="btn btn-primary">EDYTUJ</button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection

