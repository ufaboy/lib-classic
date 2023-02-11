function openBook(e) {
    if (e.target.closest('a') || e.target.closest('thead')) return;
    const row = e.target.closest('tr[data-key]');
    const id = row.getAttribute('data-key')
    const url = new URL(`/book/view`, window.location.origin)
    url.searchParams.set('id', id);
    // console.log('openBook', {host: window.location, url:url})
    window.location = url
}