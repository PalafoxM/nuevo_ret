        <script type="text/javascript">

            $(document).ready(function(){

                var Circle = null;
                var Radius = 0; //$("#radius").val();

                var StartPosition = new google.maps.LatLng($("#latitud").val(), $("#longitud").val());


                function DrawCircle(Map, Center, Radius) {

                    if (Circle != null) {
                        Circle.setMap(null);
                    }

                    if(Radius > 0) {
                        Radius *= 1609.344;
                        Circle = new google.maps.Circle({
                            center: Center,
                            radius: Radius,
                            strokeColor: "#0000FF",
                            strokeOpacity: 0.35,
                            strokeWeight: 2,
                            fillColor: "#0000FF",
                            fillOpacity: 0.20,
                            map: Map
                        });
                    }
                }

                function SetPosition(Location, Viewport) {
                    Marker.setPosition(Location);
                    if(Viewport){
                        Map.fitBounds(Viewport);
                        Map.setZoom(map.getZoom() + 2);
                    }
                    else {
                        Map.panTo(Location);
                    }
                    Radius = 0; //$("#radius").val();
                    DrawCircle(Map, Location, Radius);
                    $("#txtlatitud").val(Location.lat().toFixed(5));
                    $("#txtlongitud").val(Location.lng().toFixed(5));
                    $("#latitud").val(Location.lat().toFixed(5));
                    $("#longitud").val(Location.lng().toFixed(5));

                    /* LatLon to UTM */
                    var xy = new Array(2);
                    var lon = parseFloat ($("#txtlongitud").val());
                    var lat = parseFloat ($("#txtlatitud").val());

                    zone = Math.floor ((lon + 180.0) / 6) + 1;
                    var zone = LatLonToUTMXY (DegToRad (lat), DegToRad (lon), zone, xy);

                    $("#txtlatitudutm").val(xy[0]);
                    $("#txtlongitudutm").val(xy[1]);
                    $("#txtlatitudutm_v").val(xy[0]);
                    $("#txtlongitudutm_v").val(xy[1]);

                    /* LatLon to DMS */
                    var dmsCoords = ddToDms(lat, lon);
                    $("#txtlatitudgeo").val(dmsCoords[0]);
                    $("#txtlongitudgeo").val(dmsCoords[1]);
                    $("#txtlatitudgeo_v").val(dmsCoords[0]);
                    $("#txtlongitudgeo_v").val(dmsCoords[1]);
                }

                function SetPositionKeyPress(Location, Viewport) {
                    Marker.setPosition(Location);
                    if(Viewport){
                        Map.fitBounds(Viewport);
                        Map.setZoom(map.getZoom() + 2);
                    }
                    else {
                        Map.panTo(Location);
                    }
                    Radius = 0; //$("#radius").val();
                    DrawCircle(Map, Location, Radius);
                    $("#txtlatitud").val($("#latitud").val());
                    $("#txtlongitud").val($("#longitud").val());

                    /* LatLon to UTM */
                    var xy = new Array(2);
                    var lon = parseFloat ($("#txtlongitud").val());
                    var lat = parseFloat ($("#txtlatitud").val());

                    zone = Math.floor ((lon + 180.0) / 6) + 1;
                    var zone = LatLonToUTMXY (DegToRad (lat), DegToRad (lon), zone, xy);

                    $("#txtlatitudutm").val(xy[0]);
                    $("#txtlongitudutm").val(xy[1]);
                    $("#txtlatitudutm_v").val(xy[0]);
                    $("#txtlongitudutm_v").val(xy[1]);

                    /* LatLon to DMS */
                    var dmsCoords = ddToDms(lat, lon);
                    $("#txtlatitudgeo").val(dmsCoords[0]);
                    $("#txtlongitudgeo").val(dmsCoords[1]);
                    $("#txtlatitudgeo_v").val(dmsCoords[0]);
                    $("#txtlongitudgeo_v").val(dmsCoords[1]);
                }

                var MapOptions = {
                    zoom: 12,
                    center: StartPosition,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControl: false,
                    disableDoubleClickZoom: true,
                    streetViewControl: false
                };

                var MapView = $("#map");
                var Map = new google.maps.Map(MapView.get(0), MapOptions);

                var Marker = new google.maps.Marker({
                    position: StartPosition, 
                    map: Map, 
                    title: "Drag Me",
                    draggable: true
                });

                google.maps.event.addListener(Marker, "dragend", function(event) {
                    SetPosition(Marker.position);
                });

                /*$("#radius").keyup(function(){
                    google.maps.event.trigger(Marker, "dragend");
                }); */              
                $("#latitud").keyup(function(){
                    SetPositionKeyPress({lat: parseFloat ($("#latitud").val()), lng: parseFloat ($("#longitud").val())});
                });
                $("#longitud").keyup(function(){
                    SetPositionKeyPress({lat: parseFloat ($("#latitud").val()), lng: parseFloat ($("#longitud").val())});
                }); 

                DrawCircle(Map, StartPosition, Radius);
                SetPosition(Marker.position);

            });

        </script>
