<x-app-layout>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">MOJE ZGŁOSZENIA</h1>
    </header>
    <section class="masthead page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row justify-content-center">
                @if ($alertFm = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $alertFm }}</strong>
                    </div>
                @endif
                <a type="button" class="btn btn-success" style="margin-bottom: 20px" href="{{ route('notifications.create') }}">Dodaj zgłoszenie</a>
                <table class="table table-bordered" id="table">
                    <thead>
                    <tr>
                        <th scope="col">Usługa</th>
                        <th scope="col">Firma</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Adres</th>
                        <th scope="col">Status</th>
                        <th scope="col">Data utworzenia</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $n)
                        <tr>
                            <th scope="row">{{ $n->service }}</th>
                            <td>{{ $n->company }}</td>
                            <td>{{ $n->description }}</td>
                            <td>{{ $n->address }}</td>
                            <td>{{ $n->status }}</td>
                            <td>{{ $n->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>

</x-app-layout>
