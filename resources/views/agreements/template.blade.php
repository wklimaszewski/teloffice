<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body style="font-size: 12px">
    <h1 style="text-align: center">Umowa nr. {{ $data["agreement_number"] }}</h1>
    <div id="left" style="width: 50%; float: left">
        <h6 style="text-align: left"> Umowa abonencka zawarta pomiędzy:</h6><br>
        <strong>DOSTAWCĄ USŁUG:</strong><br>
        Nazwa firmy - {{ $data["company_name"] }} <br>
        NIP - {{ $data["company_nip"] }} <br>
        Adres - {{ $data["company_address"]  }}<br>
        Tel - {{ $data["company_phone"] }}<br>
        Email - {{ $data["company_email"] }}<br>
        Numer konta bankowego - {{ $data["company_account_number"] }}<br>
        oraz<br>
        <strong>ABONENTEM:</strong><br>
        Imię i nazwisko - {{ $data["customer_name"] }}<br>
        PESEL - {{ $data["customer_pesel"] }} <br>
        Adres - {{ $data["customer_address"] }}<br>
        Tel - {{ $data["customer_phone"] }}<br>
        Email - {{ $data["customer_email"] }}<br>
    </div>

    <div style="width: 96%; margin-left: auto; margin-right: auto; clear:both">
        <h3 style="text-align: center">Treść</h3><br>
        Na podstawie tego dokumentu Dostawca <strong>{{ $data["company_name"] }}</strong> zobowiązuje się dostarczać usługi: <br>
        @foreach($data["services"] as $service)
            - {{ $service }} zł<br>
        @endforeach
        Abonentowi <strong>{{ $data["customer_name"] }}</strong> przez okres {{ $data["agreement_duration"] }} miesięcy. Ponadto
        Dostawca zobowiązuje się do pomocy technicznej dostępnej od poniedziałku do piątku w godzinach 6:00-22:00. Abonent zobowiązuje się
        dokonywać płatności określonych przez dostawcę w wyznaczonym terminie. W przypadku zwlekania z płatnością Dostawca ma prawo do
        podjęcia działań cywilno-prawnych w celu uzyskania należytej zapłaty za świadczone usługi. <br><br><br>
        <p style="font-size: 10px">Abonent podpisując umowę wyraża zgodę na przetwarzanie danych osobowych oraz otrzymywanie materiałów marketingowych Dostawcy.</p> <br><br><br>
    </div>
    <div style="width: 30%; float: left; text-align: center">
        {{$data["customer_name"]}}
        _____________________________________<br>
        Podpis Abonenta
    </div>
    <div style="width: 30%; float: right; text-align: center">
        {{ $data["company_name"] }}
        _____________________________________<br>
        Podpis Dostawcy
    </div>
</body>
