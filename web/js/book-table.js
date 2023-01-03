const tableElement = document.querySelector('.table tbody')
function openBook(e) {
    if (e.target.closest('a')) return;
    const row = e.target.closest('tr[data-key]');
    const id = row.getAttribute('data-key')
    const url = new URL(`/book/view`, window.location.origin)
    url.searchParams.set('id', id);
    // console.log('openBook', {host: window.location, url:url})
    window.location = url
}
tableElement.addEventListener('click', openBook)
