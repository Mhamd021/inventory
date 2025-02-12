const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let marker;

function openMap(latInputId, lngInputId) {
    const latField = document.getElementById(latInputId);
    const lngField = document.getElementById(lngInputId);
    document.getElementById('mapModal').style.display = 'flex';
    mapboxgl.accessToken = 'pk.eyJ1IjoiZG9uMjEiLCJhIjoiY20yOTZtMjhoMDB3YzJqczc2YWhtenJrNiJ9.IKwkfvJWrxOZkYBlwsAhNA';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [36.059125, 36.340569],
        zoom: 7
    });
    map.on('click', (event) => {
        const coords = Object.keys(event.lngLat).map((key) => event.lngLat[key]);
        const end = {
            type: 'FeatureCollection',
            features: [{
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'Point',
                    coordinates: coords
                }
            }]
        };
        if (map.getLayer('end')) {
            map.getSource('end').setData(end);
        } else {
            map.addLayer({
                id: 'end',
                type: 'circle',
                source: {
                    type: 'geojson',
                    data: {
                        type: 'FeatureCollection',
                        features: [{
                            type: 'Feature',
                            properties: {},
                            geometry: {
                                type: 'Point',
                                coordinates: coords
                            }
                        }]
                    }
                },
                paint: {
                    'circle-radius': 10,
                    'circle-color': '#f30'
                }
            });
        }
        latField.value = coords[1];
        lngField.value = coords[0];
    });
}



function addPoint() {
    let index = document.querySelectorAll('.point').length;
    let pointHtml = ` <div class="point fade-in" id="point-${index}">
        <input type="text" name="points[${index}][point_description]" placeholder="Description" required>
        <button type="button" class="cancel" onclick="openMap('lat${index}', 'lng${index}')">location</button>
        <input type="text" id="lat${index}" name="points[${index}][latitude]" placeholder="Latitude" readonly>
        <input type="text" id="lng${index}" name="points[${index}][longitude]" placeholder="Longitude" readonly>
        <input type="file" name="points[${index}][image]">
        <button class="cancel" type="button" onclick="removePoint(null, ${index})">remove</button>
    </div>`;
    document.getElementById('points').insertAdjacentHTML('beforeend', pointHtml);

    setTimeout(() => {
        document.getElementById(`point-${index}`).classList.remove('fade-in');
    }, 400);
}



function removePoint(pointId, index) {
    let point = document.getElementById(`point-${index}`);

    if (pointId !== null) {
        $.ajax({
            url: `/points/${pointId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.success) {
                    fadeOutAndRemove(point);
                } else {
                    alert('Failed to delete the point.');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    } else {
        fadeOutAndRemove(point);
    }
}

function fadeOutAndRemove(element) {
    element.classList.add('fade-out');
    setTimeout(() => {
        element.remove();
    }, 300);
}


function deleteJourney(journeyId) {
    const form = $('<form>', {
        method: 'POST',
        action: `/journey/${journeyId}`,
    });
    form.append($('<input>', {
        type: 'hidden',
        name: '_token',
        value: csrfToken
    }));
    form.append($('<input>', {
        type: 'hidden',
        name: '_method',
        value: 'DELETE'
    }));
    $('body').append(form);
    if (confirm('Are you sure you want to delete this journey?')) {
        form.submit();
    }
}

window.deleteJourney = deleteJourney;
window.removePoint = removePoint;
window.addPoint = addPoint;
window.openMap = openMap;
