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
        <h1 class="masthead-heading mb-0">LISTA USŁUG</h1>
    </header>
    <section class="page-section portfolio">
        <div class="container">
            <div class="row justify-content-center">
                @if ($alertFm = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $alertFm }}</strong>
                    </div>
                @endif
                <table class="table table-bordered" id="table">
                    <thead>
                    <tr>
                        <th scope="col">Firma</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Cena startowa</th>
                        <th scope="col">Cena miesięczna</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service)
                        <tr>
                            <th scope="row">{{ $service->company }}</th>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->description }}</td>
                            <td>{{ $service->start_price }}</td>
                            <td>{{ $service->price_for_month }}</td>
                            <td>
                                <form action="{{ route('services.destroy',$service->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('services.edit',$service->id) }}">EDYTUJ</a>

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
