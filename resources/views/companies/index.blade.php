<x-app-layout>
    <script>
        $(document).ready(function() {
            $('#company').DataTable( {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Polish.json'
                }
            } );
        } );
    </script>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">LISTA FIRM</h1>
    </header>
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row justify-content-center">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p></p>
                    </div>
                @endif
                <table class="table table-bordered" id="company">
                    <thead>
                    <tr>
                        <th scope="col">Nazwa firmy</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Adres</th>
                        <th scope="col">Numer telefonu</th>
                        <th scope="col">Email</th>
                        <th scope="col">NIP</th>
                        <th scope="col">Numer bankowy</th>
                        <th scope="col">Województwo świadczenia usług</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($companies as $company)
                        <tr>
                            <th scope="row">{{ $company->name }}</th>
                            <td>{{ $company->description }}</td>
                            <td>{{ $company->address }}</td>
                            <td>{{ $company->phone }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->nip }}</td>
                            <td>{{ $company->account_number }}</td>
                            <td>{{ $company->county }}</td>
                            <td>
                                <form action="{{ route('companies.destroy',$company->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('companies.edit',$company->id) }}">EDYTUJ</a>

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">USUŃ</button>
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
