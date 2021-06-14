<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Map openstreetmap') }}
            <iframe width="1200" height="700" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=-198.28125%2C-64.92354174306496%2C253.82812500000003%2C82.9403268016951&amp;layer=mapnik" style="border: 1px solid black"></iframe><br/><small><a href="https://www.openstreetmap.org/#map=2/34.5/27.8">Wyświetl większą mapę</a></small>
        </h2>
    </x-slot>
</x-app-layout>