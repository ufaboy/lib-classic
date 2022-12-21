import { createApp } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

createApp({
    data() {
        return {
            images: [],
        }
    },
    methods: {
        inputFiles(evt) {
            const fileList = evt.target.files
            if (fileList) {
                for (const file of Array.from(fileList)) {
                    this.images.push({name: file.name, status: '', file: file})
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
            console.log('uploadFiles', {result: result})
        }
    }
}).mount('#storage-manager')
