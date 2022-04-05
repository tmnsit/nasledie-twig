class AjaxLoadHandler {
    constructor() {
        this.init();
    }

    ajaxReplaceContent(params) {
        params = params || {};

        const dataAttribute = params.dataAttribute;
        const $html = params.html;
        const res = params.res || {};
        const isParseSelector = params.isParseSelector === true;
        let isAppend;

        $(`[data-${dataAttribute}]`).each((key, item) => {
            const $item = $(item);
            const keyValue = $item.data(dataAttribute);

            let newHtml = false;
            isAppend = params.isAppend === true && $item.is('[data-ajax-append="true"]');

            if (isParseSelector) {
                const $replaceEl = $html.find(`[data-${dataAttribute}='${keyValue}']`);
                if ($replaceEl.length) {
                    newHtml = isAppend ? $replaceEl.html() : $replaceEl.prop('outerHTML');
                }
                // console.log('newHtml', newHtml);
                // console.log('$html', $html, params.html);
                // console.log('$item', $item);
                // console.log('$replaceEl', $replaceEl);
            } else {
                if (res.hasOwnProperty(keyValue)) {
                    newHtml = res[keyValue];
                }
            }

            if (newHtml) {
                if (isAppend) {
                    $item.append($(newHtml));
                } else {
                    $item.replaceWith(newHtml);
                }
            }
        });
    }

    /**
     * @param params
     *
     * Для того, чтобы перезагрузить часть контента на странице при нажатии на кнопку, нужно:
     *      1. Повесить на эту кнопку data-аттрибут ``data-ajax-link-to="[content-wrap-selector]"``, где ``content-wrap-selector`` - это селектор для той области, куда будет загружено содержимое
     *      2. Задать селектор для загружаемой области
     *      3. В коде страницы расставить ``Hellper::ajaxBuffer();`` / ``Hellper::ajaxBuffer(false);``
     *
     * При этом различными аспектами поведения можно управлять через data-атрибуты.
     *
     * О подмене областей при подгрузке аяксом:
     * Если на странице есть элементы,
     * у которых проставлен атрибут [data-ajax-replace-content=value],
     * и в AJAX-ответе есть ключ "value", то содержимое элемента заменяется
     * содержимым из AJAX-ответа. То есть, при необходимости обновить какой-нибудь фильтр на странице,
     * достаточно просто добавить к его обертке арибут и передать в JSON AJAX-ответа одноименный ключ.
     *
     * Список параметров:
     * -
     * self.loadContent({
     *     url: 'ссылка для загрузки контента',
     *     query: {'объект с параметрами'},
     *     method: 'get' || 'post',
     *     selector: 'селектор: куда загружать',
     *     isJson: true || false, // ответ в формате JSON или просто HTML
     *     isParseSelector: true || false, // если true, то selector будет искаться внутри HTML
     *     isPrepend: true || false, // если true, результат будет добавляться в начало
     *     isAppend: true || false, // если true, результат будет аппендиться в конец
     *     isKeepHistory: true || false, // если true, адрес в браузере не будет меняться
     *     isKeepTitle: true || false, // если true, заголовок браузера не будет меняться
     *     isKeepH1: true || false, // если true, H1 не будет меняться
     *     isScrollOnLoad: true || false, // если true, будет происходить прокрутка к началу области
     *     onSuccess: function(params, res) {}, // коллбэк, вызываемый после загрузки контента
     * });
     */
    loadContent(params) {
        const self = this;

        params = params || {};
        params.selector = params.selector || this.AJAX_CONTENT_SEL;

        // const _this = this;
        const $loadTo = $(params.selector);

        if (!$loadTo.length) {
            console.error('no-ajax-container');
            return;
        }

        params.isJson = params.isJson !== false;
        params.isParseSelector = params.isParseSelector === true;
        params.url = params.url || location.href;
        params.query = params.query || '';
        params.method = params.method || 'get';
        params.onSuccess = typeof params.onSuccess === 'function' ? params.onSuccess : false;

        params.hasOwnProperty("isAppend") || (params.isAppend = false);
        params.hasOwnProperty("isPrepend") || (params.isPrepend = false);
        params.hasOwnProperty("isKeepHistory") || (params.isKeepHistory = false);
        params.hasOwnProperty("isKeepTitle") || (params.isKeepTitle = false);
        params.hasOwnProperty("isKeepH1") || (params.isKeepH1 = false);
        params.hasOwnProperty("isScrollOnLoad") || (params.isScrollOnLoad = false);

        $(window).trigger('preloader:show', $loadTo);

        $.ajax({
            url: params.url,
            data: params.query,
            dataType: params.isJson ? 'json' : 'html',
            method: params.method,
            success: (res) => {
                $(window).trigger('preloader:hide', $loadTo);
                let html = params.isJson ? res.html : res;
                let $html;

                if (params.isParseSelector) {
                    $html = $('<div>').append(html);
                    html = $html.find(params.selector).html();
                }

                if (!html) return;

                if (params.isPrepend) {
                    $loadTo.prepend(html);
                } else if (params.isAppend) {
                    $loadTo.append(html);
                } else {
                    $loadTo.html(html);
                }

                if (params.isScrollOnLoad) {
                    $loadTo.scrollTo();
                }

                if (params.isJson) {

                    self.ajaxReplaceContent({
                        dataAttribute: 'ajax-replace-content',
                        html: $html || $(html),
                        res: res,
                        isParseSelector: params.isParseSelector,
                        isAppend: params.isAppend,
                    });

                    if (!params.isKeepHistory) {
                        history.replaceState({}, '', res.url);
                    }

                    if (!params.isKeepH1 && res.hasOwnProperty('h1') && res.h1) {
                        $('h1').html(res.h1);
                    }

                    if (!params.isKeepTitle && res.hasOwnProperty('title') && res.title) {
                        document.title = res.title;
                    }
                }

                $(window).trigger('init');

                if (params.onSuccess) {
                    params.onSuccess(params, res);
                }
            }
        });
    }

    initHandlers() {
        const self = this;

        $(document).on('reset', '[data-ajax-form-to]', function (event) {
            const $this = $(this);

            self.loadContent({
                url: $this.prop('action') || location.href,
                query: '',
                method: $this.prop('method') || 'post',
                selector: $this.data('ajax-form-to'),
                isJson: $this.data('json-content'),
                isParseSelector: $this.data('parse-selector'),
                isAppend: $this.data('append-content') || false,
                isKeepHistory: $this.data('keep-history') || false,
                isScrollOnLoad: $this.data('scroll-on-load') || false
            });
        });

        $(document).on('submit', '[data-ajax-form-to]', function (event, eventData) {
            event.preventDefault();
            const $this = $(this);
            let data;

            data = $this.serializeArray();

            let dataQuery = $this.data('query') || {};

            $.each(data, function (i, item) {
                dataQuery[item.name] = item.value;
            });

            if (typeof eventData === 'object' && typeof eventData.query === 'object') {
                $.extend(dataQuery, eventData.query);
            }

            self.loadContent({
                url: $this.data('action') || $this.prop('action'),
                query: dataQuery,
                method: $this.prop('method') || 'post',
                selector: $this.data('ajax-form-to'),
                isJson: $this.data('json-content'),
                isParseSelector: $this.data('parse-selector'),
                isAppend: $this.data('append-content') || false,
                isKeepHistory: $this.data('keep-history') || false,
                isScrollOnLoad: $this.data('scroll-on-load') || false
            });
        });

        $(document).on('click', '[data-ajax-link-to]', function (event) {
            event.preventDefault();
            const $this = $(this);

            // console.log('123');

            $this.trigger('button:loadingStart');

            self.loadContent({
                url: $this.data('href') || this.href,
                query: $this.data('query') || '',
                selector: $this.data('ajax-link-to'),
                isJson: $this.data('json-content'),
                isParseSelector: $this.data('parse-selector'),
                isAppend: $this.data('append-content') || false,
                isKeepHistory: $this.data('keep-history') || false,
                isScrollOnLoad: $this.data('scroll-on-load') || false,
                onSuccess: () => {
                    $this.trigger('button:loadingEnd');
                }
            });
        });

        $(document).on('change', '[data-submit-form]', function () {
            $(this).closest('form').trigger('submit');
        });

        $(document).on('click', '[data-submit-form-on-click]', function (event) {
            event.preventDefault();
            const $this = $(this);

            // console.log($this.data('submit-form-on-click'));

            $($this.data('submit-form-on-click')).trigger('submit', {
                query: $this.data('query')
            });
        });

        $(window).on('init.ajax', () => {
            $(window).trigger('scroll');
        });
    }

    init() {
        this.initHandlers();
    }
}

$(() => {
    window.__ajaxLoaderHandler = new AjaxLoadHandler();
});