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
    if (slideLeftRight) {
        $('.book-search').css('display', 'flex');
    }
}
document.addEventListener('touchstart', touchStart, false);
document.addEventListener('touchend', touchEnd, false);

$('.form-book').on('reset', () => {
    $('.book-search').css('display', 'none');
});
