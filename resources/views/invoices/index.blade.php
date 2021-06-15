@extends('layouts.admin')
@section('content')
    <script>
        $(document).ready(function() {
            $('#table').DataTable( {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Polish.json'
                }
            } );
        } );
    </script>
    <header class="masthead bg-primary text-white text-center" style="padding: 50px">
        <h1 class="masthead-heading mb-0">LISTA FAKTUR</h1>
    </header>
    <section class="masthead page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row justify-content-center">

                <table class="table table-bordered" id="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Umowa</th>
                        <th scope="col">Kwota</th>
                        <th scope="col">Status</th>
                        <th scope="col">Data utworzenia</th>
                        <th scope="col">Podgląd</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <th scope="row">{{ $invoice->id }}</th>
                                <td>{{ $invoice->agreement_id }}</td>
                                <td>{{ $invoice->price }} zł</td>
                                <td>
                                    @if($invoice->confirm == 1)
                                        {{ 'Opłacona' }}
                                    @else
                                        {{'Nieopłacona'}}
                                    @endif

                                </td>
                                <td>{{ $invoice->created_at }}</td>
                                <td>{{ $invoice->created_at }}</td>
                                <td>
                                    @if($invoice->confirm == 0)
                                        <button>OPŁAĆ</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>

@endsection
