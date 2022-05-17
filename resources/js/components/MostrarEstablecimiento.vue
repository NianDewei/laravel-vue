<template>
    <div class="container my-5" v-if="pageShow">
        <h2>{{ establecimiento.nombre }}</h2>
        <div class="row align-items-start">
            <div class="col-md-8 order-2">
                <template v-if="establecimiento.imagen_principal">
                    <img
                        :src="`/storage/${establecimiento.imagen_principal}`"
                        class="img-fluid"
                        alt="Imagen Establecimiento"
                    />
                </template>
                <template v-else>
                    <img
                        :src="defaultUrl"
                        class="img-fluid"
                        alt="Cargando imagen"
                    />
                </template>

                <p class="mt-3">{{ establecimiento.descripcion }}</p>
                <galeria-imagenes></galeria-imagenes>
            </div>

            <aside class="col-md-4 rounded-3 order-1">
                <div class="p-1 shadow-sm">
                    <map-ubicacion />
                </div>

                <div class="p-3 bg-primary">
                    <h2 class="text-center text-white mt-2 mb-4 fw-3">
                        Máss Información
                    </h2>

                    <p class="text-white mt-1">
                        <span class="fw-bold">Ubicación:</span>
                        {{ establecimiento.direccion }}
                    </p>
                    <p class="text-white mt-1">
                        <span class="fw-bold">Cuadra:</span>
                        {{ establecimiento.cuadra }}
                    </p>
                    <p class="text-white mt-1">
                        <span class="fw-bold">Horario:</span>
                        {{ horario }}
                    </p>
                    <p class="text-white mt-1">
                        <span class="fw-bold">Teléfono:</span>
                        {{ establecimiento.telefono }}
                    </p>
                </div>
            </aside>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import MapUbicacion from './MapUbicacion.vue'
import GaleriaImagenes from './GaleriaImagenes.vue'

export default {
    components: {
        MapUbicacion,
        GaleriaImagenes,
    },
    data() {
        return {
            defaultUrl: 'https://i.gifer.com/7YRL.gif',
            pageShow: true,
        }
    },
    mounted() {
        const { id } = this.$route.params
        const getEstablecimiento = async (id) => {
            try {
                const response = await axios.get(`/api/establecimientos/${id}`)
                mutarEstablecimiento(response)
                mutarImagenes(response)
            } catch (error) {
                // console.error(error)
                this.pageShow = false
                this.redirectTo('home')
            }
        }

        const mutarEstablecimiento = async (response) => {
            const { data } = await response
            this.$store.commit('AGREGAR_ESTABLECIMIENTO', data)
        }

        const mutarImagenes = async (response) => {
            const { data } = await response
            const { imagenes } = await data
            this.$store.commit('AGREGAR_IMAGENES', imagenes)
        }

        getEstablecimiento(id)
    },
    methods: {
        redirectTo(page) {
            this.$router.push({ name: page })
        },
    },
    computed: {
        ...mapGetters({
            establecimiento: 'getEstablecimiento',
        }),

        horario() {
            const { apertura, cierre } = this.establecimiento
            const horario = `${apertura} - ${cierre}`
            return horario
        },
    },
}
</script>
