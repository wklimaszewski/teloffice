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

        input[type=submit] {
            background-color: DodgerBlue;
            color: #fff;
            cursor: pointer;
        }

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
    </div>
    <div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Nazwa:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Nazwa">
                </div>
            </div>
        </div>
    </div>

<script src="js/OpenLayers-2.13.1/OpenLayers.js"></script>
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
                            if(result.address.house_number != null)
                            {
                                document.getElementById("pokaz").innerHTML = "<label>Znaleziony adres:</label><br>"+result.display_name+"<br><label>lon&lat:</label><br>lon: "
                                    +result.lon+"<br>lat: "+result.lat+"<br><button>POTWIERDŹ</button><br><p>Znaleziono budynek + (opcjonalnie informacja w jakiej odległości)</p>";

                            }
                            else
                            {
                                document.getElementById("pokaz").innerHTML = "<label>Znaleziony adres:</label><br>"+result.display_name+"<br><label>lon&lat:</label><br>lon: "
                                    +result.lon+"<br>lat: "+result.lat+"<br><button>POTWIERDŹ</button><br>";

                            }
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
                        document.getElementById("pokaz").innerHTML = "<label>Znaleziony adres:</label><br>"+result[0].display_name+"<br><label>lon&lat:</label><br>lon: "
                            +result[0].lon+"<br>lat: "+result[0].lat+"<br><button>POTWIERDŹ</button><br>";
                    }
                }
            }
        });
    }

    function Check()
    {
        if(document.getElementById('miasto').value.length %4!=0){
            // podpowiedz_miasto();
            document.getElementById("ulica").disabled = false;
        }
        // else
        //     autocomplete(document.getElementById("miasto"), nazwa, gmina, powiat,wojew,sym);
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
                            document.getElementById("pokaz").innerHTML = "<label>Znaleziony adres:</label><br>"+result.display_name+"<br>lon: "
                                +result.lon+"<br>lat: "+result.lat+"<br><button>POTWIERDŹ</button><br>";
                        }
                        else
                        {
                            document.getElementById("pokaz").innerHTML = "<label>Znaleziony adres:</label><br>"+result.display_name+"<br><label>lon&lat:</label><br>lon: "
                                +result.lon+"<br>lat: "+result.lat+"<br><button>POTWIERDŹ</button><br>";
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

