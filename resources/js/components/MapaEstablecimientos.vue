<template>
    <div class="mapa">
        <l-map :zoom="zoom" :center="center" :options="mapOptions">
            <l-tile-layer :url="url" />
            <l-marker
                v-for="{
                    id,
                    nombre,
                    lat,
                    lng,
                    categoria,
                } in allEstablecimientos"
                :key="id"
                :latLng="{ lat: lat, lng: lng }"
                :icon="iconEstablecimiento(categoria)"
                @click="redirectToBy(id)"
            >
                <l-tooltip> {{ nombre }} - {{ categoria.nombre }}</l-tooltip>
            </l-marker>
        </l-map>
    </div>
</template>

<script>
import { latLng } from 'leaflet'
import { LMap, LTileLayer, LMarker, LTooltip, LIcon } from 'vue2-leaflet'
import { mapGetters } from 'vuex'

export default {
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LTooltip,
        LIcon,
    },
    data() {
        return {
            zoom: 14,
            center: latLng(-6.777378379908338, -79.83871948842203),
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            currentZoom: 11.5,
            // currentCenter: latLng(-6.777378379908338, -79.83871948842203),
            showParagraph: false,
            mapOptions: {
                zoomSnap: 0.5,
            },
            showMap: true,
        }
    },
    created() {
        const getEstablecimientos = async () => {
            const url = '/api/establecimientos'
            const response = await axios.get(url)
            mutarEstablecimientos(response)
        }

        const mutarEstablecimientos = async (response) => {
            const { data } = response
            this.$store.commit('AGREGAR_TODOS_ESTABLECIMIENTOS', data)
            this.$store.commit('AGREGAR_TODOS_ESTABLECIMIENTOSOLDS', data)
        }
        getEstablecimientos()
    },
    computed: {
        ...mapGetters({
            allEstablecimientos: 'getTodosEstablecimientos',
            oldsEsblecimientos: 'getOldsEstablecimientos',
            categoriaState: 'getSelectedCategory',
        }),
    },
    methods: {
        iconEstablecimiento(categoria) {
            const { slug } = categoria
            const options = {
                iconUrl: `images/icons/${slug}.svg`,
                iconSize: [40, 50],
            }

            return L.icon(options)
        },
        returnNewEstablecimientosBy(id, data) {
            const establecimientos = data.filter((establecimiento) => {
                return establecimiento.categoria_id == id
            })

            return establecimientos
        },
        mutarEstablecimientos(data) {
            this.$store.commit('AGREGAR_TODOS_ESTABLECIMIENTOS', data)
        },
        redirectToBy(id){
            this.$router.push({name:'establecimiento', params:{id}})
        }
    },
    watch: {
        categoriaState: function () {
            const data = this.oldsEsblecimientos
            const idCategoria = this.categoriaState

            const newEstablecimientos = this.returnNewEstablecimientosBy(
                idCategoria,
                data
            )

            this.mutarEstablecimientos(newEstablecimientos)
        },
    },
}
</script>

<style scoped>
.mapa {
    height: 600px;
    widows: 100%;
}
</style>
