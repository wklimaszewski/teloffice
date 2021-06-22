<x-app-layout>
    <link  rel = " stylesheet " href = " https://openlayers.org/en/latest/css/ol.css "/>
    <script  type = " text/javascript " src = " https://openlayers.org/en/latest/build/ol.js "> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <meta charset="utf-8">
    <style>
        #przeslij
        {
            border: 1px solid #088;
            border-radius: 10px;
            margin-left: 45%;
            background-color: orange;

        }
        .autocomplete {
            position: relative;
            display: inline-block;
        }

        input {
            border: 1px solid transparent;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 16px;
        }

        input[type=text] {
            background-color: #f1f1f1;
            width: 100%;
        }

        /*input[type=submit] {*/
        /*    background-color: DodgerBlue;*/
        /*    color: #fff;*/
        /*    cursor: pointer;*/
        /*}*/

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 1px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
        datalist{
            padding: 1px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
            width: 400%;
        }
        datalist-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }
        datalist-items div {
            padding: 1px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }
    </style>
    <header class="masthead bg-primary text-white text-center" >
        <h1 class="masthead-heading mb-0" >DODAJ ZGŁOSZENIE</h1>
    </header><br>
        <div class="row justify-content-center">
            <div id="Map" style="height: 400px; width: 60%;"></div>
            <div id="info" style="float:left; height: 400px; width: 33%; margin: 10px; overflow: auto">
                <h3 style="text-align: center;">Lista dostępnych firm w wybranej lokalizacji</h3>
                <ul class="list-group" id="lista"></ul>
            </div>
        </div>
        <div>
            <div class="row justify-content-left">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group" style="text-align: center">
                        <strong>Wpisz adres lub zaznacz punkt na mapie:</strong><br>
                        <label>Miejscowość:</label>
                        <input type="text" name="miasto" id="miasto" placeholder="Podaj miasto" onkeyup="Check()"><br>
                        <label>Ulica, numer domu:</label>
                        <input type="text" name="ulica" id="ulica" placeholder="Podaj ulicę" onkeyup="Check()"><br>
                        <label>Kod pocztowy(opcjonalnie):</label>
                        <input type="text" name="kod_pocztowy" id="kod_pocztowy" placeholder="Podaj kod pocztowy" onkeyup="Check()"><br>
                        <input type="button" class="btn btn-dark" onclick="szukaj()" value="ZAZNACZ">
                    </div>

                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group" style="margin: 20px">
                        <div class="row justify-content-center">
                            <input type="button" class="btn btn-secondary" value="ZLOKALIZUJ MNIE" name="Lokalizuj" onclick="namierz()" />
                        </div>
                        <div class="row justify-content-center" style="margin: 20px">
                            <input type="button" class="btn btn-secondary" value="USUŃ ZNACZNIK" onclick="usunZnacznik()" />
                        </div>

                    </div>
                </div>
                <br><br>
            </div>
        </div>


    <script src="{{asset('js/OpenLayers-2.13.1/OpenLayers.js')}}"></script>
    <script>


        var lat            = 53.150714471012115;
        var lon            = 23.087574825337995;

        var lat1           = 53.150334788254185;
        var lon1            = 23.085678782677878;

        var zoom           = 7.7;

        var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
        var toProjection   = new OpenLayers.Projection("EPSG:3857"); // to Spherical Mercator Projection
        var position       = new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
        var position1       = new OpenLayers.LonLat(lon1, lat1).transform( fromProjection, toProjection);
        map = new OpenLayers.Map("Map");

        var mapnik         = new OpenLayers.Layer.OSM();
        map.addLayer(mapnik);

        map.setCenter(position,zoom);

        var markers = new OpenLayers.Layer.Markers( "Markers" );
        map.addLayer(markers);
        markers.addMarker(new OpenLayers.Marker(position));
        markers.addMarker(new OpenLayers.Marker(position1));

        function CenterMap(lon, lat)
        {
            map.setCenter(ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857'),15);
        }

        function check_company(woj)
        {
            var div = document.getElementById("info");
            var ul = document.getElementById('lista');
            ul.innerHTML="";
            $.ajax({
                url: "/map_check",
                type: 'GET',
                data:{ 'woj':woj},
                success: function(elements){
                    elements.forEach(myFunction);

                    function myFunction(item, index) {
                        var li = document.createElement('li');
                        li.innerHTML = item.name;
                        li.setAttribute("class", "list-group-item");
                        var form = document.createElement('form');
                        form.setAttribute("action", "{{ route('uslugi') }}");
                        var input = document.createElement('input');
                        input.setAttribute("type", "hidden");
                        input.setAttribute("value", item.id);
                        input.setAttribute("name", "company_id");
                        var submit = document.createElement('input');
                        submit.setAttribute("type", "submit");
                        submit.setAttribute("value", "ZOBACZ OFERTĘ");
                        submit.setAttribute("class", "btn btn-dark");
                        form.appendChild(input);
                        form.appendChild(submit);
                        li.appendChild(form);
                        ul.appendChild(li);
                    }
                    div.appendChild(ul);

                },
                error: function (er)
                {
                    var ul = document.getElementById('lista');
                    ul.innerHTML="";
                    var li = document.createElement('li');
                    li.innerHTML = "Wybrano błędną lokalizację ! ";
                    ul.appendChild(li);
                }
            });
        }

        function uzupelnij(wynik)
        {
            console.log(wynik);
            if(typeof wynik.city !== 'undefined')
            {
                document.getElementById("miasto").value = wynik.city;
                if(typeof wynik.road !== 'undefined' && typeof wynik.house_number !== 'undefined')
                    document.getElementById("ulica").value = wynik.road+" "+wynik.house_number;
            }
            else
            {
                if(typeof wynik.village !== 'undefined')
                {
                    document.getElementById("miasto").value = wynik.village;
                    if(typeof wynik.road !== 'undefined' && typeof wynik.house_number !== 'undefined')
                        document.getElementById("ulica").value = wynik.road+" "+wynik.house_number;
                    else if (typeof wynik.house_number !== 'undefined')
                    {
                        document.getElementById("ulica").value = wynik.house_number;
                    }
                }
                else
                {
                    document.getElementById("miasto").value = wynik.town;
                    if(typeof wynik.road !== 'undefined' && typeof wynik.house_number !== 'undefined')
                    {
                        document.getElementById("ulica").value = wynik.road+" "+wynik.house_number;
                    }
                    else if (typeof wynik.house_number !== 'undefined')
                    {
                        document.getElementById("ulica").value = wynik.house_number;
                    }
                }
            }

            if(typeof wynik.postcode !== 'undefined')
                document.getElementById("kod_pocztowy").value = wynik.postcode;
        }

        function namierz()
        {
            var lok = navigator.geolocation;
            if(lok)
            {
                usunZnacznik();
                lok.getCurrentPosition(function(location) {
                    var lokalizuj       = new OpenLayers.LonLat(location.coords.longitude, location.coords.latitude).transform( fromProjection, toProjection);
                    markers.addMarker(new OpenLayers.Marker(lokalizuj));
                    CenterMap(location.coords.longitude, location.coords.latitude);
                    $.ajax({
                        url: "https://nominatim.openstreetmap.org/reverse?lon="+location.coords.longitude+"&lat="+location.coords.latitude+"&format=json&addressdetails=1",
                        success: function(result)
                        {
                            if(result!=0)
                            {
                                uzupelnij(result.address);
                                if(result.address.country=="Polska")
                                    check_company(result.address.state);
                                else
                                    document.getElementById("lista").innerHTML = "";
                            }
                        },
                        error: function()
                        {
                            alert('blad');
                        }

                    });
                });
            }

            else
            {
                alert('Brak zgody na pobranie lokalizacji');
            }
        }

        function szukaj()
        {
            usunZnacznik();
            $.ajax({
                url: "https://nominatim.openstreetmap.org/search?city="+document.getElementById('miasto').value+"&street="+document.getElementById('ulica').value+
                    "&postalcode="+document.getElementById('kod_pocztowy').value+"&format=json&addressdetails=1",
                success: function( result )
                {
                    if(result[0]==null)
                    {
                        alert('Błędny adres');
                    }
                    else
                    {
                        if(document.getElementById('miasto').value<2)
                        {
                            alert('Podaj miasto');
                        }
                        else
                        {
                            var pos = new OpenLayers.LonLat(result[0].lon, result[0].lat).transform( fromProjection, toProjection);
                            markers.addMarker(new OpenLayers.Marker(pos));
                            CenterMap(result[0].lon, result[0].lat);
                            if(result[0].address.country=="Polska")
                                check_company(result[0].address.state);
                            else
                                document.getElementById("lista").innerHTML = "";
                        }
                    }
                }
            });
        }

        function Check()
        {
            if(document.getElementById('miasto').value.length >2 )
            {
                document.getElementById("ulica").disabled = false;
            }
        }

        function dodajZnacznik()
        {
            map.getViewport().addEventListener("dblclick", function(e)
            {
                var lonlat = map.getLonLatFromPixel(e.xy);
                coord= new OpenLayers.LonLat(lonlat.lon,lonlat.lat).transform(toProjection,fromProjection);
                usunZnacznik();
                $.ajax({
                    url: "https://nominatim.openstreetmap.org/reverse?lon="+coord.lon+"&lat="+coord.lat+"&format=json",
                    success: function(result)
                    {
                        if(result!=0)
                        {
                            var min = zmierz(coord.lat,coord.lon,result.lat,result.lon);
                            var jeden = zmierz(coord.lat,coord.lon,result.boundingbox[0],result.boundingbox[2]);
                            var dwa = zmierz(coord.lat,coord.lon,result.boundingbox[1],result.boundingbox[3])
                            var najmniej;
                            if(result.address.house_number != null)
                            {
                                if(min>jeden)
                                {
                                    min = jeden;
                                    if(min>dwa)
                                        najmniej=dwa;
                                    else
                                        najmniej=min;
                                }
                                else
                                {
                                    if(min>dwa)
                                        najmniej=dwa;
                                    else
                                        najmniej=min;
                                }
                                if(najmniej<101){
                                    var pos       = new OpenLayers.LonLat(result.lon, result.lat).transform( fromProjection, toProjection);
                                    markers.addMarker(new OpenLayers.Marker(pos));
                                }
                                else
                                {
                                    var pos       = new OpenLayers.LonLat(coord.lon, coord.lat).transform( fromProjection, toProjection);
                                    markers.addMarker(new OpenLayers.Marker(pos));
                                }
                                uzupelnij(result.address);
                                if(result.address.country=="Polska")
                                    check_company(result.address.state);
                                else
                                    document.getElementById("lista").innerHTML = "";
                            }
                            else
                            {
                                uzupelnij(result.address);
                                if(result.address.country=="Polska")
                                    check_company(result.address.state);
                                else
                                    document.getElementById("lista").innerHTML = "";
                                var pos       = new OpenLayers.LonLat(coord.lon, coord.lat).transform( fromProjection, toProjection);
                                markers.addMarker(new OpenLayers.Marker(pos));
                            }
                        }
                        else
                        {
                            alert('blad');
                        }

                    },
                    error: function()
                    {
                        alert('blad');
                    }
                });

            });
        }

        function usunZnacznik()
        {
            markers.clearMarkers();
            map.setCenter(ol.proj.transform([19.095353598806504, 52.22279090653282], 'EPSG:4326', 'EPSG:3857'),5.6);
        }

        function zmierz(lat1, lon1, lat2, lon2)
        {
            var R = 6378.137; //radiany ziemii
            var dLat = lat2 * Math.PI / 180 - lat1 * Math.PI / 180;
            var dLon = lon2 * Math.PI / 180 - lon1 * Math.PI / 180;
            var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            var b = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            var c = R * b;
            return c * 1000; // metry (granica błędu 5-7m)
        }

        dodajZnacznik();

    </script>



    <br>


</x-app-layout>

