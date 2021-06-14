@extends('layouts.app')

@section('content')
<div class="container">
    @if (session()->has('messege'))
    <div class="alert alert-success" role="alert">
    <strong>Udało się !</strong> {{ session()->get('messege')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    @endif
    <h1 style="text-align:center">Wpisz swoje dane, aby utworzyć umowę</h1>
    <form action="{{ route('agreements.create') }}"  method="get">
    <div class="form-group">
        <label for="name">Imie:</label>
        <input type="text" class="form-control" id="name" name="name" maxlength="20" placeholder="Wpisz imie">
    </div>
    <div class="form-group">
        <label for="surname">Nazwisko:</label>
        <input type="text" class="form-control" id="surname" name="surname" maxlength="36" placeholder="Wpisz nazwisko">
    </div>
    <div class="form-group">
        <label for="adres">Adres:</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="Wpisz adres">
    </div>
    <div class="form-group">
        <label for="pesel">Pesel:</label>
        <input type="number" class="form-control" id="pesel" name="pesel" placeholder="Wpisz pesel">
    </div>
    <div class="form-group">
        <label for="tel">Numer telefonu:</label>
        <input type="number" class="form-control" id="tel" name="tel" placeholder="Wpisz nr telefonu">
    </div>
    <div class="form-group">
        <label for="usluga">Usługa:</label>
        <select class="form-control" name="usluga" id="usluga">
            <option selected disabled>Wybierz usługę</option>
            <option value="INTERNET 10Mbs">INTERNET 10Mbs</option>
            <option value="INTERNET 20Mbs">INTERNET 20Mbs</option>
            <option value="INTERNET 50Mbs">INTERNET 50Mbs</option>
            <option value="INTERNET 100Mbs">INTERNET 100Mbs</option>
            <option value="INTERNET 500Mbs">INTERNET 500Mbs</option>
            <option value="PAKIET TV FAMILIJNY">PAKIET TV FAMILIJNY</option>
            <option value="PAKIET TV PREMIUM">PAKIET TV PREMIUM</option>
            <option value="PAKIET TV FAMILIJNY + INTERNET 50Mbs">PAKIET TV FAMILIJNY + INTERNET 50Mbs</option>
            <option value="PAKIET TV FAMILIJNY + INTERNET 100Mbs">PAKIET TV FAMILIJNY + INTERNET 100Mbs</option>
            <option value="PAKIET TV FAMILIJNY + INTERNET 500Mbs">PAKIET TV PREMIUM + INTERNET 500Mbs</option>
        </select>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="checkbox" required>
        <label class="form-check-label" for="checkbox">*Wyrażam zgodę na przetwarzanie moich danych osobowych</label>
    </div>
    <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
    <br>
@endsection