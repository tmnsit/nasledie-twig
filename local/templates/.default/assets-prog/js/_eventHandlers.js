$(() => {

    (function ajaxHandlers() {
    })();

    (function setLinksTargetBlank() {
        // noinspection JSCheckFunctionSignatures
        const $window = $(window);

        // noinspection JSUnresolvedFunction
        $window.on('init.linksTarget', () => {
            $('a:not([target]), a[target=""]').each((i, item) => {
                const $item = $(item);
                let href = $item.prop('href');

                if (href && typeof href === 'object' && href.baseVal) {
                    href = href.baseVal;
                }

                try {

                    if (
                        href &&
                        (
                            (
                                href.indexOf(location.origin) !== 0 && href.indexOf('http') === 0
                            ) ||
                            href.match(/\.(pdf|doc|docx|pptx)\/?$/)
                        )
                    ) {
                        $item.attr('target', '_blank');
                    }

                } catch (e) {

                    // console.log(href, $item)

                }
            });
        });

        $window.trigger('init.linksTarget');
    })();

});
