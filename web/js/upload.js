import {createApp} from '/js/vue.esm-browser.js'

createApp({
    name: 'ImageUpdate',
    data() {
        return {
            image: null,
        }
    },
    created() {
        this.image = imageSrc
    },
    methods: {
        inputFile(evt) {
            const fileList = evt.target.files
            if (fileList && fileList.length) {
                this.image = fileList[0]
            }
        },
        async uploadFile(e) {
            const searchParams = new URLSearchParams(window.location.search);
            const response = await fetch(`/upload/single?id=${searchParams.get('id')}`, {
                method: 'POST',
                body: new FormData(e.target)
            });
            let result = await response.json();
            this.images = result
            console.log('uploadFiles', {result: result})
        },
        getName(image) {
            return image.id ? `${image.file_name}` : image.name
        },
        getUrl(image) {
            console.log('img', image)
            return typeof this.image === 'string' ? `/${this.image}` : this.image.id ? `/${this.image.path}/${this.image.file_name}` : window.URL.createObjectURL(image);
        },
    }
}).mount('#image-update')
