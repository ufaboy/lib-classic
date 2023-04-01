const formBtnSave = document.getElementById('book-save-btn')
formBtnSave.addEventListener('click', saveBook)
async function saveBook(e) {
    e.preventDefault()
    const textElement = document.getElementById('text')
    const text = textElement.innerHTML
    const textInput = document.getElementById('book-text')
    textInput.value = text
    const btnSend = document.getElementById('form-send-btn')
    btnSend.click()
}
/*
const {createApp} = Vue
createApp({
    name: 'BookUpdateText',
    data() {
        return {
            images: [],
        }
    },
    mounted() {
        this.images = images
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
            return image.id ? `${image.file_name}` : image.name
        },
        getUrl(image) {
            return image.id ? `/${image.path}/${image.file_name}` : window.URL.createObjectURL(image);
        },
        async copyUrl(image) {
            const path = `${image.path}/${image.file_name}`
            console.log('copyUrl', navigator, image, path)
            await navigator.clipboard.writeText(`<img class="picture" src="/${path}">`)
        }
    }
}).mount('#book-update-text')
*/
