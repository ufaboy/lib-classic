const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 1
}
const loadData = function (entries, observer) {
    if (!entries[0].isIntersecting) return;
    console.log('observer', {entries: entries, observer: observer})

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
            // var html = $(text);
            // $('#p0').append(html.find('.list-view').html());
            // $('body').find('.pagination').html(html.find('.pagination').html());
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
    if (slideLeftRight) showForm()
}

function showForm() {
    $('.book-search').css('display', 'flex');
    $('.form-book').on('reset', () => hideForm());
    $('body').on('keyup', e => {
        if (e.key === "Escape") hideForm();
    });
}

function hideForm() {
    $('.book-search').css('display', 'none');
    $('.form-book').unbind()
    $('body').unbind()
}

$('#btn-sort').click(e => {
    $('#btn-sort').value === 'desc' ? $('#btn-sort').value('btn-asc') : $('#btn-sort').value('btn-desc')
})
document.addEventListener('touchstart', touchStart, false);
document.addEventListener('touchend', touchEnd, false);

$('#show-filter').click(showForm);
