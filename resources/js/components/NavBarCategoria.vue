<template>
    <div>
        <nav class="navbar navbar-light bg-gray">
            <div class="container-fluid justify-content-center">
                <a
                    class="btn btn-sm btn-outline-primary me-2"
                    @click="showAllLocation"
                    >Todos</a
                >
                <a
                    class="btn btn-sm btn-outline-secondary me-2"
                    v-for="{ id, nombre } in categorias"
                    :key="id"
                    @click="sendCategoryBy(id, $event)"
                    >{{ nombre }}</a
                >
            </div>
        </nav>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    data() {
        return {
            buttonActive: {},
        }
    },
    created() {
        const getCategorias = async () => {
            const url = '/api/categorias'
            const response = await axios.get(url)
            mutarCategorias(response)
        }

        const mutarCategorias = async (response) => {
            const { data } = await response
            const categorias = await data
            this.$store.commit('AGREGAR_CATEGORIAS', categorias)
        }

        getCategorias()
    },
    computed: {
        ...mapGetters({
            categorias: 'getStateCategorias',
            oldsEsblecimientos: 'getOldsEstablecimientos',
        }),
    },
    methods: {
        sendCategoryBy(id, event) {
            this.$store.commit('AGREGAR_SELECCION_CATEGORIA', id)
            this.buttonActive = event.target
        },
        showAllLocation() {
            const data = this.oldsEsblecimientos
            this.$store.commit('AGREGAR_TODOS_ESTABLECIMIENTOS', data)
            this.removeClassActive(this.buttonActive)
        },
        addClassActive(button) {
            const siContiene = button.classList.contains('btn-outline-secondary')
            if(siContiene){button.classList.remove('btn-outline-secondary')}
            button.classList.add('btn-outline-primary')
            button.classList.add('bg-primary')
            button.classList.add('text-white')
        },
        removeClassActive(button) {
            button.classList.add('btn-outline-secondary')
            button.classList.remove('btn-outline-primary')
            button.classList.remove('bg-primary')
            button.classList.remove('text-white')
        },
    },
    watch: {
        buttonActive: function (value, oldvalue) {
            if (oldvalue.textContent) this.removeClassActive(oldvalue)
            this.addClassActive(value)
        },
    },
}
</script>
