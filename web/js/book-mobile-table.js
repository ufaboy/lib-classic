let infinityLoading = count === 20;
// console.log('count', count)
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 1
}
const loadData = function (entries, observer) {
    if (!entries[0].isIntersecting || !infinityLoading) return;
    // console.log('observer', {entries: entries, observer: observer})
    let page = document.getElementById('mobile-book-table')
    const url = document.querySelector('.pagination .next a').href
    $.ajax({
        url: url,
        beforeSend: function (xhr) {
        },
        success: function (response) {
            let newDiv = document.createElement('div')
            newDiv.innerHTML = response
            let newList = newDiv.querySelectorAll('.book-list li')
            let newPaginationList = newDiv.querySelector('.pagination')
            page.querySelector('.book-list').append(...newList)
            page.querySelector('.pagination').innerHTML = newPaginationList.innerHTML
            infinityLoading = newList.length === 20
        }
    });
};
const observer = new IntersectionObserver(loadData, observerOptions);

let targetObserver = document.getElementById('observer')
observer.observe(targetObserver);

let startPos = {x: 0, y: 0};
let endPos = {x: 0, y: 0};
let slideLeftRight = false
let slideRightLeft = false

function touchStart(e) {
    slideLeftRight = false
    slideRightLeft = false
    startPos = {x: e.changedTouches[0].clientX, y: e.changedTouches[0].clientY}
    endPos = {x: 0, y: 0}
}

function touchEnd(e) {
    endPos = {x: e.changedTouches[0].clientX, y: e.changedTouches[0].clientY}
    let difX = endPos.x - startPos.x
    let difY = startPos.y - endPos.y
    if (difX > 100 && difY < 50) {
        slideLeftRight = true
    } else if (difX < -100 && difY < 50) {
        slideRightLeft = true
    }
    if (slideLeftRight) showFilter()
    if (slideRightLeft) showSort()
}

function showFilter() {
    $('.book-search').css('display', 'flex');
    $('.form-filter-book').on('reset', () => hideFilter());
    $('body').on('keyup', e => {
        if (e.key === "Escape") hideFilter();
    });
}
function showSort() {
    $('.book-sort').css('display', 'flex');
    $('.form-sort-book').on('reset', () => hideFilter());
    $('body').on('keyup', e => {
        if (e.key === "Escape") hideFilter();
    });
}

function hideFilter() {
    $('.book-search').css('display', 'none');
    $('.book-sort').css('display', 'none');
    $('.form-filter-book').unbind()
    $('.form-sort-book').unbind()
    $('body').unbind()
}

$('#btn-sort').click(e => {
    $('#btn-sort').value === 'desc' ? $('#btn-sort').value('btn-asc') : $('#btn-sort').value('btn-desc')
})
document.addEventListener('touchstart', touchStart, false);
document.addEventListener('touchend', touchEnd, false);

$('#show-filter').click(showFilter);
