            var customLabel = {
                restaurant: {
                    label: 'R'
                },
                bar: {
                    label: 'B'
                }
            };
            function initMap() {
                var map = new google.maps.Map(document.getElementById('googleMap'), {
                    center: new google.maps.LatLng(51.391423, 27.175312),
                    zoom: 5
                });
                var infoWindow = new google.maps.InfoWindow;
                // Change this depending on the name of your PHP or XML file
                downloadUrl('test2.xml', function (data) {
                    var xml = data.responseXML;
                    var markers = xml.documentElement.getElementsByTagName('marker');
                    Array.prototype.forEach.call(markers, function (markerElem) {
                        var id = markerElem.getAttribute('id');
                        var place = markerElem.getAttribute('place');
                        var country = markerElem.getAttribute('country');
                        var type = markerElem.getAttribute('type');
                        var point = new google.maps.LatLng(
                                parseFloat(markerElem.getAttribute('lat')),
                                parseFloat(markerElem.getAttribute('lng')));
                        var infowincontent = document.createElement('div');
                        var strong = document.createElement('strong');
                        strong.textContent = id
                        infowincontent.appendChild(strong);
                        infowincontent.appendChild(document.createElement('br'));
                        var text = document.createElement('text');
                        text.textContent = place
                        infowincontent.appendChild(text);
                        var icon = customLabel[type] || {};
                        var marker = new google.maps.Marker({
                            map: map,
                            position: point,
                            label: icon.label
                        });
                        marker.addListener('click', function () {
                            infoWindow.setContent(infowincontent);
                            infoWindow.open(googleMap, marker);
                            window.location.href = "query1.php?id=" + id + "&country=" + country + "&place=" + place;
                        });
                    });
                });
            }



            function downloadUrl(url, callback) {
                var request = window.ActiveXObject ?
                        new ActiveXObject('Microsoft.XMLHTTP') :
                        new XMLHttpRequest;
                request.onreadystatechange = function () {
                    if (request.readyState == 4) {
                        request.onreadystatechange = doNothing;
                        callback(request, request.status);
                    }
                };
                request.open('GET', url, true);
                request.send(null);
            }

            function doNothing() {}