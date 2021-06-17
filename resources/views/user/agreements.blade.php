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
        <h1 class="masthead-heading mb-0">MOJE UMOWY</h1>
    </header>
    <section class="page-section portfolio">
        <div class="container">
            <div class="row justify-content-center">
                <table class="table table-bordered" id="table">
                    <thead>
                    <tr>
                        <th scope="col">Numer umowy</th>
                        <th scope="col">Firma</th>
                        <th scope="col">Usługa</th>
                        <th scope="col">Czas trwania</th>
                        <th scope="col">Cena aktywacji</th>
                        <th scope="col">Opłata miesieczna</th>
                        <th scope="col">Data podpisania</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($agreements as $agreement)
                        <tr>
                            <th>{{ $agreement->number }}</th>
                            <td>{{ $agreement->company }}</td>
                            <td>{{ $agreement->service }}</td>
                            <td>{{ $agreement->duration }}</td>
                            <td>{{ $agreement->start_price }}zł</td>
                            <td>{{ $agreement->price_for_month }}zł</td>
                            <td>{{ $agreement->created_at }}</td>
                            <td>
                                <form action="{{ route('pobierz_umowe') }}">
                                    <input type="hidden" name="agreement" value="{{ $agreement->id }}">
                                    <button type="submit" class="btn btn-warning">POBIERZ UMOWĘ</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
