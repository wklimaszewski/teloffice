<x-app-layout>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">DODAJ FAKTURĘ</h1>
    </header>
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
                <form action="{{ route('invoices.store') }}" method="post">
                    <div class="form-group">
                        <label for="agreement">Wpisz numer umowy</label>
                        <input list="agreements_list" type="text" value="" class="form-control" id="agreement" name="agreement" placeholder="Wybierz umowę">
                        <datalist id="agreements_list">
                            @foreach($agreements as $agreement)
                                <option value="{{$agreement->id}}">{{$agreement->number}}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="number">Kwota</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Wpisz kwotę faktury">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

        </div>
    </section>

</x-app-layout>
