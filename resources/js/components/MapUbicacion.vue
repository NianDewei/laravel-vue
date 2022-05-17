<template>
    <div class="mapa">
        <l-map :zoom="zoom" :center="center" :options="mapOptions" zIndex="500">
            <l-tile-layer :url="url"/>
            <l-marker :latLng="{ lat, lng }">
                <l-tooltip>{{nombre}}</l-tooltip>
            </l-marker>
        </l-map>
    </div>
</template>

<script>
import { latLng } from 'leaflet'
import { LMap, LTileLayer, LMarker, LTooltip } from 'vue2-leaflet'
import { mapGetters } from 'vuex'

export default {
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LTooltip,
    },
    data() {
        return {
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            center: latLng(-6.777378379908338, -79.83871948842203),
            zoom: 16,
            currentZoom: 11.5,
            mapOptions: {
                zoomSnap: 0.5,
            },
            // markerLatLng: [51.504, -0.159],
            lat: '',
            lng: '',
        }
    },
    created() {
        setTimeout(() => {
            this.showLocation
            this.centerLocation
        }, 300)
    },
    computed: {
        ...mapGetters({
            establecimiento: 'getEstablecimiento',
        }),

        showLocation() {
            const { lat, lng } = this.establecimiento
            this.lat = lat
            this.lng = lng
        },
        centerLocation(){
            const { lat, lng } = this.establecimiento
            this.center = latLng(this.lat, this.lng)
        },
        nombre(){
            const {nombre} = this.establecimiento
            return nombre
        }
    },
}
</script>

<style scoped>
@import 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css';
.mapa {
    height: 300px;
    width: 100%;
}
</style>
