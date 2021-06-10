<x-app-layout>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">LISTA USŁUG</h1>
    </header>
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row justify-content-center">
                <table class="table table-bordered">
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
                            <td>{{ $invoice->name }}</td>
                            <td>{{ $invoice->description }}</td>
                            <td>{{ $invoice->start_cost }}</td>
                            <td>{{ $invoice->cost_for_month }}</td>
                            <td>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>

</x-app-layout>
