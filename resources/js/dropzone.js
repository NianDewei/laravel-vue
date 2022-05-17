document.addEventListener('DOMContentLoaded', () => {
    Dropzone.autoDiscover = false
    const tokenCSRF = document.querySelector('meta[name=csrf-token]').content
    const options = {
        url: '/imagenes/store',
        maxFiles: 10,
        dictDefaultMessage: 'Sube hasta 10 imágenes',
        required: true,
        acceptedFiles: '.png,.jpg,.jpeg',
        addRemoveLinks: true,
        dictRemoveFile: 'Eliminar',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        },
        init: function () {
            const galeria = document.querySelectorAll('.galeria')
            const uuid = document.getElementById('uuid')
            const tieneImagenes = galeria.length
            if (tieneImagenes) {
                galeria.forEach(imagen => {
                    const imagenPublicada = {}
                    imagenPublicada.size = 1
                    imagenPublicada.name = imagen.value

                    imagenPublicada.nameImageInServer = imagen.value

                    const ruta_imagen = `/storage/${imagenPublicada.name}`

                    this.options.addedfile.call(this, imagenPublicada)
                    this.options.thumbnail.call(this, imagenPublicada, ruta_imagen)

                    imagenPublicada.previewElement.classList.add('dz-success')
                    imagenPublicada.previewElement.classList.add('dz-complete')
                })

            }
        },
        success: (file, response) => {
            file.nameImageInServer = response.archivo
            // console.log(response)
        },
        sending: (file, xhr, formData) => {

            formData.append('uuid', uuid.value)
        },
        removedfile: (file, response) => {
            const params = {
                imagen: file.nameImageInServer,
                uuid: uuid.value,
            }

            const destroyImage = async params => {
                const response = await axios.post('/imagenes/destroy', params)
                //    console.log(response)
                //eliminar del DOM
                file.previewElement.parentNode.removeChild(file.previewElement)
            }

            destroyImage(params)
        }
    }

    const dropzone = new Dropzone('#dropzone', options)
})
