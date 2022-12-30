"use strict";
import {createApp} from '/js/vue.esm-browser.js'

function saveProgress() {
    localStorage.setItem(`book_${id}`, String(Math.floor(document.documentElement.scrollTop)))
}

function scrollToMark() {
    const mark = localStorage.getItem(`book_${id}`)
    window.scrollTo(0, +mark)
}

// Функция throttle будет принимать 2 аргумента:
// - callee, функция, которую надо вызывать;
// - timeout, интервал в мс, с которым следует пропускать вызовы.
function throttle(callee, timeout) {
    // Таймер будет определять,
    // надо ли нам пропускать текущий вызов.
    let timer = null

    // Как результат возвращаем другую функцию.
    // Это нужно, чтобы мы могли не менять другие части кода,
    // чуть позже мы увидим, как это помогает.
    return function perform(...args) {
        // Если таймер есть, то функция уже была вызвана,
        // и значит новый вызов следует пропустить.
        if (timer) return

        // Если таймера нет, значит мы можем вызвать функцию:
        timer = setTimeout(() => {
            // Аргументы передаём неизменными в функцию-аргумент:
            callee(...args)

            // По окончании очищаем таймер:
            clearTimeout(timer)
            timer = null
        }, timeout)
    }
}

const optimizedHandler = throttle(saveProgress, 250)

$(window).scroll(e => {
    optimizedHandler()
});
scrollToMark()

createApp({
    name: 'Book',
    data() {
        return {
            headerChapters: [],
            chapterElement: null,
            bottomShow: false
        }
    },
    mounted() {
        this.prepareHeaders()
    },
    methods: {
        scrollToChapter() {
            this.bottomShow = false
            if (this.chapterElement) this.chapterElement.element.scrollIntoView()
        },
        calcOptionChapterName(chapter) {
            const chapterElem = chapter.querySelector('.chapter-header')
            return chapterElem ? chapterElem.innerHTML : ''
        },
        async prepareHeaders() {
            let arr = []
            const chapterElements = document.querySelectorAll('.chapter')
            const h1Element = document.querySelector('.book-name')

            if (h1Element) {
                const item = {name: 'Table Of Content', url: '/', element: h1Element}
                arr.push(item)
                this.chapterElement = {name: 'Table Of Content', url: '/', element: h1Element}
            }
            for (const elem of chapterElements) {
                arr.push({name: this.calcOptionChapterName(elem), url: elem.id, element: elem})
            }
            this.headerChapters = arr
        }
    }
}).mount('#book-view')