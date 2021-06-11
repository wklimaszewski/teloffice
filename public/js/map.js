
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

