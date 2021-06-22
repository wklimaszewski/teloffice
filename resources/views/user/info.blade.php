<x-app-layout>

    <div class=" masthead container">

        <div class="row justify-content-center">
            <h1 style="color: green">Gratulacje podpisałeś umowę nr. {{$agreement->number}}</h1>
        </div>
        <div style="width: 80%; margin-right: auto; margin-left: auto; margin-top: 20px; margin-bottom: 20px">
            <img src="{{ asset('images/confirm.jpg') }}" style="width: 100%">
        </div>
        <div class="row justify-content-center">
            <form action="{{ route('pobierz_umowe') }}">
                <input type="hidden" name="agreement" value="{{ $agreement->id }}">
                <button style="margin: 10px" type="submit" class="btn btn-dark">Pobierz umowę</button>
            </form>
            <form action="{{ route('pobierz_fakture') }}">
                <input type="hidden" name="invoice" value="{{ $invoice->id }}">
                <button style="margin: 10px" type="submit" class="btn btn-dark">Pobierz fakturę</button>
            </form>
        </div>
        </div>
</x-app-layout>
