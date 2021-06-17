<x-app-layout>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">POTWIERDZENIE</h1>
    </header>

    <div class="container" style="margin-top: 50px;">
        <form action="{{ route('gotowe') }}">
        <div class="row justify-content-center">
            <div class="row">
                <p style="font-size: 24px">Ja, <strong>{{$customer->name." ".$customer->surname}}</strong> wyrażam chęć odpłatnego korzystania z usług
                firmy <strong>{{ $company->name }}</strong> przez okres <select name="duration" class="sm">
                        <option value="12" selected>12</option>
                        <option value="24" selected>24</option>
                        <option value="36" selected>36</option>
                    </select> miesięcy oraz deklaruje dokonywać płatności w wysokości {{$service->price_for_month}}zł za
                    świadczone usługi. Jednocześnie potwierdzam poprawność moich danych osobowych:
                </p>
            </div><br>
        </div>
            <p>
                Imię: {{$customer->name}}<br>
                Nazwisko: {{ $customer->surname }}<br>
                Adres: {{ $customer->address }}<br>
                PESEL: {{ $customer->pesel }}<br>
                Tel: {{ $customer->phone }}<br>
                Email: {{ $customer->email }}<br>
            </p>
        <div class="row justify-content-center">
            <input type="hidden" name="service" value="{{ $service}}">
            <input type="hidden" name="company" value="{{ $company }}">
            <input type="hidden" name="customer" value="{{ $customer }}">
            <button type="submit" class="btn btn-success" style="margin-bottom: 50px">POTWIERDZAM CHĘĆ ZAWARCIA UMOWY</button>
        </div>
        </form>
</x-app-layout>
