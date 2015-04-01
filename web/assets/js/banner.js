$.fn.bannerRotate = function(options) {
    var parameters = {
        height: 100,
        itemTag: 'li',
        offset: 1,
        timeout: 5
    };
    $.extend(parameters, options);

    var container = this,
        items = container.find('li').clone(),
        start = 0,
        wrapper = container.find('ul'),
        is_first_run = true;

    container.height(parameters.height);
    wrapper.html('');

    function run() {
        if (is_first_run) {
            wrapper.hide();
            is_first_run = false;
        } else {
            wrapper.fadeIn();
        }
        var itemsToShow = items.slice(start, start + parameters.offset).toArray();
        if (itemsToShow.length < parameters.offset) {
            //if we don't have enough items to show - get rest from the start of list
            var additionalItems = items.slice(0, (parameters.offset - itemsToShow.length)).toArray();
            $.each(additionalItems, function() {
                itemsToShow.push(this);
            });
            //reset start pointer on the next item after last added
            //distract offset to compensate increment in the end of function
            start = additionalItems.length - parameters.offset;
        }
        wrapper.html(itemsToShow);
        wrapper.fadeIn();
        start += parameters.offset;
    }

    if (items.length > parameters.offset) {
        run();
        setInterval(run, parameters.timeout * 1000);
    }
};
