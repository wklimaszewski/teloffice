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
        <h1 class="masthead-heading mb-0">LISTA KLIENTÓW</h1>
    </header>
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row justify-content-center">
                <table class="table table-bordered" id="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Imię</th>
                        <th scope="col">Nazwisko</th>
                        <th scope="col">Adres</th>
                        <th scope="col">Numer telefonu</th>
                        <th scope="col">Email</th>
                        <th scope="col">Pesel</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <th scope="row">{{ $customer->id }}</th>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->surname }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->pesel }}</td>
                                <td>
                                    <form action="{{ route('customers.destroy',$customer->id) }}" method="POST">

                                        <a class="btn btn-primary" href="{{ route('customers.edit',$customer->id) }}">EDYTUJ</a>

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
