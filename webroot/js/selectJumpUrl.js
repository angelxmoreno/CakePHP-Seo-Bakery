const fn = () => {
    const selectJumpUrl = document.getElementsByClassName('select-jump-url');
    console.log('selectJumpUrl', selectJumpUrl)
    Array.from(selectJumpUrl).forEach((element) => element.addEventListener('change', (event) => {
        console.log('event', event)
        const name = event.currentTarget.name;
        const value = event.currentTarget.value;
        const searchParams = new URLSearchParams(window.location.search);
        if (value !== '0') {
            searchParams.set(name, value);
        } else {
            searchParams.delete(name);
        }
        searchParams.delete('page');
        window.location.search = searchParams.toString();
    }))


}
if (document.readyState !== 'loading') {
    fn();
} else {
    document.addEventListener('DOMContentLoaded', fn);
}
