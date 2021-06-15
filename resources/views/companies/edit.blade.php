@extends('layouts.admin')
@section('content')
    <header class="masthead bg-primary text-white text-center" style="padding: 50px">
        <h1 class="masthead-heading mb-0">EDYTUJ FIRMĘ</h1>
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

                <form action="{{ route('companies.update',$company->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nazwa:</strong>
                                <input type="text" name="name" value="{{ $company->name }}" class="form-control" placeholder="Nazwa">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Opis:</strong>
                                <textarea class="form-control" style="height:100px" name="description" placeholder="Opis">{{ $company->description }}</textarea>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Adres:</strong>
                                <input type="text" name="address" value="{{ $company->address }}" class="form-control" placeholder="Adres">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Numer telefonu:</strong>
                                <input type="number" name="phone" value="{{ $company->phone }}" class="form-control" placeholder="Numer telefonu">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Email:</strong>
                                <input type="email" name="email" value="{{ $company->email }}" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>NIP:</strong>
                                <input type="number" name="nip" value="{{ $company->nip }}" class="form-control" placeholder="NIP">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Numer konta bankowego:</strong>
                                <input type="number" name="account_number" value="{{ $company->account_number }}" class="form-control" placeholder="Numer konta bankowego">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Województwo Świadczenia Usług:</strong>
                                <select name="area_id" class="form-control">
                                    <option value="{{ $company->area_id }}" selected>{{ $area->county }}</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->county }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('dashboard') }}"> COFNIJ</a>
                                <button type="submit" class="btn btn-primary">EDYTUJ</button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
