<x-app-layout>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">UZUPEŁNIJ INFORMACJE</h1>
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

                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Imię:</strong>
                                <input type="text" name="name" class="form-control" placeholder="Imię">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nazwisko:</strong>
                                <input type="text" name="surname"  class="form-control" placeholder="Nazwisko">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Adres:</strong>
                                <input type="text" name="address"  class="form-control" placeholder="Adres">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Numer telefonu:</strong>
                                <input type="number" name="phone" class="form-control" placeholder="Numer telefonu">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Email:</strong>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Pesel:</strong>
                                <input type="number" name="pesel" class="form-control" placeholder="Pesel">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('dashboard') }}"> COFNIJ</a>
                                <button type="submit" class="btn btn-primary">GOTOWE</button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
</x-app-layout>
