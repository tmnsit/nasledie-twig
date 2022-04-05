window.UPLAB_LOAD_LIBS = true;
__webpack_public_path__ = __webpack_public_path__ || '/';


// Файлы начинающиеся с '_' можно импортировать, они не компилируются сами по себе
const loadModules = () => {
    document.dispatchEvent(new CustomEvent('UPLAB.LibsLoaded'));

    require('./_common');
    require('./_ajaxLoadHandler.class');
    require('./_eventHandlers');
};


// TODO переделать на промисы
const asyncLoadJs = (url, onload) => {
    let script = document.createElement('script');
    script.onload = onload;
    script.src = __webpack_public_path__ + url;
    const parentNode = document.querySelector('head');
    parentNode && parentNode.appendChild(script);
};


const checkLoadedLibs = () => {
    if (typeof jQuery === 'undefined') {

        asyncLoadJs('cashAdvanced.js', () => {
            console.log('Cash loaded!', $);
            loadModules();
        });

    } else {
        loadModules();
    }
};


// Если jQuery уже есть, то не ждем собитие DOMContentLoaded.
// Иначе дожидаемся, пока страница будет загружена и загружаем Cash,
// если нет jQuery
if (typeof jQuery === 'function') {
    checkLoadedLibs();
} else {
    document.addEventListener('DOMContentLoaded', checkLoadedLibs);
}
