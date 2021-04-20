<x-app-layout>
    <form action="{{ route('agreements.create') }}"  method="get">
    <div class="form-group">
        <label for="name">Imie:</label>
        <input type="text" class="form-control" id="name" placeholder="Wpisz imie">
    </div>
    <div class="form-group">
        <label for="surname">Nazwisko:</label>
        <input type="text" class="form-control" id="surname" placeholder="Wpisz nazwisko">
    </div>
    <div class="form-group">
        <label for="adres">Adres:</label>
        <input type="text" class="form-control" id="address" placeholder="Wpisz adres">
    </div>
    <div class="form-group">
        <label for="pesel">PESEL:</label>
        <input type="text" class="form-control" id="pesel" placeholder="Wpisz pesel">
    </div>
    <div class="form-group">
        <label for="adres">Usługa:</label>
        <select class="form-select">
            <option selected disabled>Wybierz usługę</option>
            <option value="NET10">INTERNET 10Mbs</option>
            <option value="NET20">INTERNET 20Mbs</option>
            <option value="NET50">INTERNET 50Mbs</option>
            <option value="NET100">INTERNET 100Mbs</option>
            <option value="NET500">INTERNET 500Mbs</option>
            <option value="TV_INT">TELEWIZJA INTERNETOWA</option>
            <option value="TV_C">TELEWIZJA CYFROWA</option>
        </select>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</x-app-layout>