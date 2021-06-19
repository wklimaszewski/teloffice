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
        <h1 class="masthead-heading mb-0">LISTA UMÓW</h1>
    </header>
    <section class="masthead page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row justify-content-center">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered" id="table">
                    <thead>
                    <tr>
                        <th scope="col">Numer umowy</th>
                        <th scope="col">Firma</th>
                        <th scope="col">Klient</th>
                        <th scope="col">Czas trwania</th>
                        <th scope="col">Cena startowa</th>
                        <th scope="col">Cena miesięczna</th>
                        <th scope="col">Data utworzenia</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($agreements as $agreement)
                        <tr>
                            <th scope="row">{{ $agreement->number }}</th>
                            <td>{{ $agreement->company }}</td>
                            <td>{{ $agreement->customer_name." ".$agreement->customer_surname }}</td>
                            <td>{{ $agreement->duration }}</td>
                            <td>{{ $agreement->start_price }}</td>
                            <td>{{ $agreement->price_for_month }}</td>
                            <td>{{ $agreement->created_at }}</td>
                            <td>
                                <form action="{{ route('agreements.destroy',$agreement->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('agreements.edit',$agreement->id) }}">EDYTUJ</a>

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

@endsection
