var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($)
{
    e107.behaviors.initQuickSelect = {
        attach: function (context, settings)
        {
            $(context).find('#navigator').once('quick-select').each(function () {
                $(this).quickselect({
                    activeButtonClass: e107.settings.links_page.activeButtonClass,
                    breakOutValues: e107.settings.links_page.breakOutValues,
                    breakOutAll: e107.settings.links_page.breakOutAll,                   
                    buttonClass: e107.settings.links_page.buttonClass,
                    selectDefaultText: e107.settings.links_page.selectDefaultText,
                    wrapperClass: e107.settings.links_page.wrapperClass
                });
            });       
            $(context).find('#link_navigator_allcat').once('quick-select').each(function () {
                $(this).quickselect({
                    activeButtonClass: e107.settings.links_page.activeButtonClass,
                    breakOutValues: e107.settings.links_page.breakOutValues,
                    breakOutAll: e107.settings.links_page.breakOutAll,                   
                    buttonClass: e107.settings.links_page.buttonClass,
                    selectDefaultText: e107.settings.links_page.selectDefaultText,
                    wrapperClass: e107.settings.links_page.wrapperClass
                });
            });
                     
        }
    };

})(jQuery);