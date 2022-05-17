<template>
    <silent-box :gallery="gallery" ref="silentbox"> </silent-box>
</template>

<script>

  import {mapGetters} from 'vuex'

export default {
    computed:{
        ...mapGetters({
            gallery: 'getImagenes'
        }),
    },
}
</script>
