<template>
    <div>
        <nav-bar-categoria />
        <mapa-establecimientos />
        <categoria-establecimiento nombre="cafe" categoria="Cafés" />
        <categoria-establecimiento
            nombre="restaurante"
            categoria="Restaurantes"
        />
        <categoria-establecimiento nombre="hoteles" categoria="Hoteles" />
    </div>
</template>

<script>
import CategoriaEstablecimiento from './CategoriaEstablecimiento.vue'
import MapaEstablecimientos from './MapaEstablecimientos.vue'
import NavBarCategoria from './NavBarCategoria.vue'
export default {
    components: {
        CategoriaEstablecimiento,
        MapaEstablecimientos,
        NavBarCategoria,
    },
}
</script>
