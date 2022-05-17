import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        categorias: {},
        categoria: {},
        establecimientos: {},
        establecimientosOld: {},
        establecimiento: {},
        imagenes: [],
    },
    mutations: {
        AGREGAR_ESTABLECIMIENTO(state, data) {
            state.establecimiento = data
        },

        AGREGAR_IMAGENES(state, imagenes) {
            const galeria = imagenes.map((imagen) => {
                return {
                    src: `/storage/${imagen.ruta_imagen}`,
                    thumbnailWidth: '220px',
                }
            })
            state.imagenes = galeria
        },

        AGREGAR_TODOS_ESTABLECIMIENTOS(state, data) {
            state.establecimientos = data
        },

        AGREGAR_TODOS_ESTABLECIMIENTOSOLDS(state,data){
            state.establecimientosOld = data
        },

        AGREGAR_CATEGORIAS(state, data) {
            state.categorias = data
        },

        AGREGAR_SELECCION_CATEGORIA(state,categoria){
            state.categoria = categoria
        }
    },
    getters: {
        getEstablecimiento: state => state.establecimiento,
        getTodosEstablecimientos: state => state.establecimientos,
        getOldsEstablecimientos: state => state.establecimientosOld,
        getImagenes: state => state.imagenes,
        getStateCategorias: state => state.categorias,
        getSelectedCategory: state => state.categoria
    }
})


