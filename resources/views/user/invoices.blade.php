<x-app-layout>
    <script>
        $(document).ready(function() {
            $('#table').DataTable( {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Polish.json'
                }
            } );
        } );
    </script>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">MOJE FAKTURY</h1>
    </header>
    <section class="page-section portfolio">
        <div class="container">
            <div class="row justify-content-center">
                <table class="table table-bordered" id="table">
                    <thead>
                    <tr>
                        <th scope="col">Numer faktury</th>
                        <th scope="col">Numer umowy</th>
                        <th scope="col">Firma</th>
                        <th scope="col">Usługa</th>
                        <th scope="col">Kwota</th>
                        <th scope="col">Opłacona</th>
                        <th scope="col">Data utworzenia</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <th>{{ $invoice->number }}</th>
                            <th>{{ $invoice->agreement }}</th>
                            <td>{{ $invoice->company }}</td>
                            <td>{{ $invoice->service }}</td>
                            <td>{{ $invoice->price }}zł</td>
                            <td>
                                @if($invoice->confirm==0)
                                    {{'NIE'}}
                                @else
                                    {{'TAK'}}
                                @endif
                            </td>
                            <td>{{ $invoice->created_at }}</td>
                            <td>
                                <form action="{{ route('pobierz_fakture') }}">
                                    <input type="hidden" name="invoice" value="{{ $invoice->id }}">
                                    <button type="submit" class="btn btn-warning sm">POBIERZ</button>
                                </form>
                                @if($invoice->confirm==0)
                                    <button type="submit" class="btn btn-dark sm">OPŁAĆ</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
