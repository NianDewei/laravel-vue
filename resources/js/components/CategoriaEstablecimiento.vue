<template>
    <div class="container my-5">
        <h2>{{ categoria }}</h2>
        <div class="row">
            <div
                class="col-md-4 mt-4"
                v-for="establecimiento in establecimientos"
                :key="establecimiento.id"
            >
                <div class="card shadow rounded-3">
                    <img
                        :src="`storage/${establecimiento.imagen_principal}`"
                        alt="Establecimiento"
                        class="card-img-top"
                    />
                    <div class="card-body">
                        <h3 class="card-title text-primary fw-bold">
                            {{ establecimiento.nombre }}
                        </h3>
                        <p class="card-text">{{ establecimiento.direccion }}</p>
                        <p class="card-text">
                            <span class="fw-bold">Horario:</span>
                            {{ establecimiento.apertura }} -
                            {{ establecimiento.cierre }}
                        </p>
                        <router-link
                            class="btn btn-primary d-block text-uppercase text-decoration-none"
                            :to="{
                                name: 'establecimiento',
                                params: { id: establecimiento.id },
                            }"
                        >
                        ver lugar
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        nombre: {
            type: String,
            required: true,
        },
        categoria: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            establecimientos: []
        }
    },
    mounted() {
        const getEstablecimiento = async () => {
            try {
                const url = `/api/categorias/${this.nombre}`
                const response = await axios.get(url)
                setEstablecimiento(response)
            } catch (error) {
                console.error('Warning: ', error)
            }
        }

        const setEstablecimiento = async (response) => {
            const { data } = response
            this.establecimientos = data
        }

        getEstablecimiento()
    },
}
</script>
<style>
a.silentbox-item {
    padding: 5px;
}
a.silentbox-item > img {
    border-radius: 5px;
}
.leaflet-top,
.leaflet-bottom {
    z-index: 500 !important;
}
</style>
