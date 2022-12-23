import { createApp } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

createApp({
    data() {
        return {
            images: [],
        }
    },
    mounted() {
        this.images = storages
        console.log('storages', storages)
    },
    methods: {
        inputFiles(evt) {
            const fileList = evt.target.files
            if (fileList) {
                for (const file of Array.from(fileList)) {
                    this.images.push(file)
                }
            }
        },
        async uploadFiles(e) {
            const searchParams = new URLSearchParams(window.location.search);
            const response = await fetch(`/upload?book_id=${searchParams.get('id')}`, {
                method: 'POST',
                body: new FormData(e.target)
            });
            let result = await response.json();
            this.images = result
            // if (Array.isArray(result)) {
            //     for (const elem of result) {
            //         this.images
            //     }
            // }
            console.log('uploadFiles', {result: result})
        },
        getName(image) {
            return image.id ? `${image.file_name}.${image.extension}` : image.name
        },
        getUrl(image) {
            return image.id ? `/${image.path}/${image.file_name}.${image.extension}` : window.URL.createObjectURL(image);
        },
        async copyUrl(image) {
            const path = `${image.path}/${image.file_name}.${image.extension}`
            console.log('copyUrl', navigator, image, path)
            await navigator.clipboard.writeText(`<img class="picture" src="/${path}">`)
        }
    }
}).mount('#storage-manager')
