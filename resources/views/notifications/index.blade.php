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
        <h1 class="masthead-heading mb-0">LISTA ZGŁOSZEŃ</h1>
    </header>
    <section class="masthead page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row justify-content-center">

                <table class="table table-bordered" id="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Usługa</th>
                        <th scope="col">Firma</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Adres</th>
                        <th scope="col">Status</th>
                        <th scope="col">Data utworzenia</th>
                        <th scope="col">Zmień status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $n)
                        <tr>
                            <th scope="row">{{ $n->id }}</th>
                            <td>{{ $n->service }}</td>
                            <td>{{ $n->company }}</td>
                            <td>{{ $n->description }}</td>
                            <td>{{ $n->address }}</td>
                            <td>{{ $n->status }}</td>
                            <td>{{ $n->created_at }}</td>
                            <td>
                                <form action="{{ route('update_status') }}">
                                    <input type="hidden" value="{{ $n->id }}" name="id">
                                    <select name="status">
                                        <option value="Przyjęto">Przyjmij</option>
                                        <option value="W trakcie realizacji">Realizuj</option>
                                        <option value="Zakończono">Zakończ</option>
                                    </select>
                                    <input type="submit" value="OK">
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
