document.addEventListener('DOMContentLoaded', () => {


    const apikey = 'AAPK98fdabd1f5384fc7b379dfebc939bcf1pWT9IOx2X_BAXCCNEB5zhqOw8HQ8RKvTBLLVj0hwoLuAxQ_3sVbAITMPjFSbiFih'
    const searchForCoordinates = L.esri.Geocoding.geocodeService({
        apikey
    })

    const searchForAddress = L.esri.Geocoding.geocode({
        apikey
    })

    // capturar texto de busqueda
    const addressInput = document.getElementById('b-direccion')
    // const selectResults = document.getElementById('search-results')
    //mostrar en
    const direccion = document.getElementById('direccion')
    const cuadra = document.getElementById('cuadra')
    //guardar coordenadas en:
    const saveLatitude = document.getElementById('lat')
    const saveLongitude = document.getElementById('lng')

    //mapa
    const latitude  = saveLatitude.value  || -6.777378379908338
    const longitude = saveLongitude.value || -79.83871948842203
    const locationForDefault = [latitude, longitude]
    const zoomMap = 16
    const options = {
        draggable: true, //mover el ping
        autoPan: true, //mapa en moviemiento
    }
    const mapa = L.map('mapa').setView(locationForDefault, zoomMap)
    // eliminar pines previos
    const markers = new L.FeatureGroup().addTo(mapa)

    let marker;
    marker = new L.marker([latitude, longitude], options).addTo(mapa)
    markers.addLayer(marker)

    //---- funciones
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright"> OpenStreetMap</a> contributors'
    }).addTo(mapa);

    /*------------------------------------------------------------------
     *  we detect the movement of the pointer
     */
    const movementManager = eventMap => {
        //capturar la ubicación segun segun el pointer
        const movement = eventMap.target
        const {
            lat,
            lng
        } = movement.getLatLng() //location
        const coordinates = new L.LatLng(lat, lng)

        //centrar automaticamente
        mapa.panTo(coordinates)
        // render in map and inputs address / block
        reverseGeocoding(coordinates, zoomMap)
    }

    const reLocationPointer = marker => {
        marker.on('moveend', (eventMap) => {
            movementManager(eventMap)
        })
    }

    marker.on('moveend', (eventMap) => {
        movementManager(eventMap)
    })

    /*------------------------------------------------------------------*/

    // Reverse Geocoding, cuando el usuario reubica el pin
    const reverseGeocoding = (coordinates, zoomMap) => {
        searchForCoordinates.reverse().latlng(coordinates, zoomMap).run((error, location) => {

            const {
                address
            } = location
            //render data in popup the pointer
            marker.bindPopup(address.LongLabel)
            marker.openPopup();

            // valid then render
            validationLocationCoordinates(location)
        })
    }

    const validationLocationCoordinates = location => {

        const {
            Address
        } = location.address
        const dataOfCoordinates = Boolean(Address);

        // if response is true render, else send message
        (dataOfCoordinates) ? renderAddressData(location) : messageNotFoundAddress();
    }

    const validationLocationSearch = location => {

        const {
            ShortLabel
        } = location.properties
        const dataOfSearch = Boolean(ShortLabel);

        // if response is true render, else send message
        (dataOfSearch) ? renderAddressData(location) : messageNotFoundAddress();
    }

    const messageNotFoundAddress = () => {
        // value of the inputs
        direccion.value = ''
        cuadra.value = ''
        // placeholder
        direccion.placeholder = 'Dirección no encontrada , escriba una referencial'
        cuadra.placeholder = 'No se encontró'
    }

    // renderizar datos
    const renderAddressData = location => {

        const {
            Address,
            City,
            Region,
            Block
        } = location.address || location.properties

        let address = Address || location.properties.ShortLabel

        const {
            lat,
            lng
        } = location.latlng

        const fullAddress = `${address} | ${City} - ${Region}`

        // fill form
        direccion.value = fullAddress
        cuadra.value = Block

        // save coordinates
        saveLatitude.value = lat
        saveLongitude.value = lng
    }

    //search from input
    addressInput.addEventListener('blur', (eventInput) => {
        const address = eventInput.target.value
        // eventInput.code === 'Enter' &&
        if (address.length > 10) {
            const getLocation = async () => {
                try {
                    const response = await queryForAddress(address)
                    // clear pointer previews
                    markers.clearLayers()
                    // validar
                    validationLocationSearch(response)
                    // centrar
                    mapa.setView(response.latlng)
                    // agregar ping
                    marker = new L.marker(response.latlng, {
                        draggable: true,
                        autoPan: true
                    }).addTo(mapa)
                    // agregar un popup
                    marker.bindPopup(response.text)
                    marker.openPopup();

                    markers.addLayer(marker)
                    // relocation pointer
                    reLocationPointer(marker)
                } catch (error) {
                    //send menssage to div id:message-result
                }
            }
            getLocation()
        }
    })

    const queryForAddress = address => {
        return new Promise((res, rej) => {
            searchForAddress.text(address).run((err, data) => {
                const location = data.results.shift();
                (location) ? res(location) : rej(false);
            })
        })
    }

})

